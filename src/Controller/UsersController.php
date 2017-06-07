<?php

namespace App\Controller;

use App\Controller\AppController;
use Aura\Intl\Exception;
use Cake\Event\Event;

class UsersController extends AppController {
  /**
   * {@inheritdoc}
   */
  public function initialize() {
    parent::initialize();
    $this->loadModel('Roles');
    $this->loadModel('Articles');
    $this->loadComponent('Flash'); // Include the FlashComponent
    $this->loadComponent('Paginator');
  }

  /**
   * {@inheritdoc}
   */
  public function beforeFilter(Event $event) {
    parent::beforeFilter($event);
  }

  /**
   * {@inheritdoc}
   */
  public function beforeRender(Event $event) {

    // Allow signUp, logout and login.
    if (in_array($this->request->getParam('action'), ['signup', 'login', 'logout', 'profile', 'view']) || $this->role === 3) {
      return TRUE;
    }

    $entityId = $this->getEntityId();
    if ($this->request->getParam('action') === 'edit' && $entityId === $this->user_id) {
      return TRUE;
    }

    $this->goHome();
  }

  public function index($limit = 10) {
    $users = $this->paginate($this->Users->find('all')->contain('Roles'), [
      'limit' => $limit
    ]);

    $this->set(compact('users'));
    $this->set('_serialize', ['users']);
  }

  public function view($id = null) {
    TRY {
      $user = $this->Users->get($id);
      $this->set(compact('user'));
    } CATCH (Exception $e) {
      $this->goHome();
    }

  }

  public function profile() {
    empty($_GET['sort_by']) ? $sort_by = 'Articles.created' : $sort_by = $_GET['sort_by'];
    empty($_GET['type_sort']) ? $type_sort = 'DESC' : $type_sort = $_GET['type_sort'];

    $userId = $this->Auth->user('id');

    $this->view($userId);
    $this->set('articles', $this->Paginator->paginate($this->Articles->find('all'), [
        'conditions' => ['user_id' => $userId],
        'limit' => 10,
        'order' => [
          $sort_by => $type_sort,
        ]
      ]
    ));

    if ($type_sort == 'ASC') {
      $this->set(['type_sort' => 'DESC']);
    } else {
      $this->set(['type_sort' => 'ASC']);
    }

  }

  public function login() {
    if ($this->request->is('post')) {
      $user = $this->Auth->identify();
      if ($user) {
        $this->Auth->setUser($user);
        $log = 'User with alias `' . $user['alias'] . '`` login.';
        $this->setLog($log);
        return $this->redirect($this->Auth->redirectUrl());
      }
      $log = 'Invalid alias or password, try again';
      $this->setLog($log);
      $this->Flash->error(__($log));
    }
  }

  public function logout() {
    return $this->redirect($this->Auth->logout());
  }

  public function signUp() {
    $this->add();
  }

  public function add($redirect = 'index') {
    $user = $this->Users->newEntity();

    $this->getRoleList();

    if ($this->request->is('post')) {
      $user = $this->Users->patchEntity($user, $this->request->getData());
      if ($this->Users->save($user)) {
        $log = 'User have been created.';
        $this->setLog($log);
        $this->Flash->success(__($log));

        $this->redirect(['action' => $redirect]);
      } else {
        $log = 'Unable to save user.';
        $this->setLog($log);
        $this->Flash->error(__($log));
      }
    }
    $this->set('user', $user);
  }

  public function edit($id = NULL) {

    if ($id === NULL) {
      $id = $this->Auth->user('id');
    }

    $user = $this->Users->get($id);

    $this->getRoleList();

    if ($this->request->is(['post', 'put'])) {
      $this->Users->patchEntity($user, $this->request->getData());
      if ($this->Users->save($user)) {
        $log = 'Your user has been updated.';
        $this->setLog($log);
        $this->Flash->success(__($log));
        return $this->redirect( $this->referer() );
      }
      $log = 'Unable to update your user';
      $this->setLog($log);
      $this->Flash->error(__($log));
    }
    $this->set('user', $user);
  }

  public function delete($id) {
    $this->request->allowMethod(['post', 'delete']);

    $articles = $this->Articles->find('all', [
      'conditions' => [
        'Articles.user_id' => $id,
      ],
    ]);
    foreach ($articles as $article) {
      $article = $this->Articles->get($article->id);
      $this->Articles->delete($article);
    }

    $user = $this->Users->get($id);
    if ($this->Users->delete($user)) {
      $log = 'The user with id: ' . $id . ' has been deleted.';
      $this->setLog($log);
      $this->Flash->success(__($log));

      return $this->redirect(['action' => 'index']);
    }
  }

  /**
   * Gets role list.
   */
  private function getRoleList() {
    $roles = $this->Roles->find('all');
    foreach ($roles as $role) {
      $role_name[$role->id] = $role->role_name;
    }
    $this->set(compact('role_name'));
  }

}