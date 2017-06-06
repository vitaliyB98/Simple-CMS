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
    if (in_array($this->request->getParam('action'), ['signup', 'login', 'logout', 'profile']) || $this->role === 3) {
      return TRUE;
    }

    $entityId = $this->getEntityId();
    if ($this->request->getParam('action') === 'edit' && $entityId === $this->user_id) {
      return TRUE;
    }

    $this->goHome();
  }

  public function index() {
    $users = $this->Users->find('all');
    $this->set(compact('users'));
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

    if (empty($sort_by)) {
      $sort_by = 'Articles.created';
    }

    if (empty($type_sort)) {
      $type_sort = 'DESC';
    }

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

  }

  public function login() {
    if ($this->request->is('post')) {
      $user = $this->Auth->identify();
      if ($user) {
        $this->Auth->setUser($user);

        return $this->redirect($this->Auth->redirectUrl());
      }
      $this->Flash->error(__('Invalid alias or password, try again'));
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
        $this->Flash->success(__('User have been created.'));

        $this->redirect(['action' => $redirect]);
      } else {
        $this->Flash->error(__('Unable to save user.'));
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
        $this->Flash->success(__('Your user has been updated.'));
        return $this->redirect( $this->referer() );
      }
      $this->Flash->error(__('Unable to update your user'));
    }
    $this->set('user', $user);
  }

  public function delete($id) {
    $this->request->allowMethod(['post', 'delete']);

    $user = $this->Users->get($id);
    if ($this->Users->delete($user)) {
      $this->Flash->success(__('The user with id: {0} has been deleted.', h($id)));

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