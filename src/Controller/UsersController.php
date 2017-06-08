<?php

namespace App\Controller;

use Cake\Event\Event;

class UsersController extends AppController {

  /**
   * Initialize method.
   */
  public function initialize() {
    parent::initialize();
    $this->loadModel('Roles');
    $this->loadModel('Articles');
  }

  /**
   * Before filter method.
   */
  public function beforeFilter(Event $event) {
    parent::beforeFilter($event);
  }

  /**
   * Before render.
   *
   * @param $event
   *   Event object.
   *
   * @return bool
   */
  public function beforeRender(Event $event) {

    // Allow signUp, profile, logout and login.
    if (in_array($this->request->getParam('action'), ['signup', 'login', 'logout', 'profile', 'view']) || $this->role === 3) {
      return TRUE;
    }

    $entityId = $this->getEntityId();
    if ($this->request->getParam('action') === 'edit' && $entityId === $this->user_id) {
      return TRUE;
    }

    $this->goHome();

    return NULL;
  }

  /**
   * Index method.
   *
   * @param int $limit
   *
   * @return bool
   */
  public function index($limit = 20) {
    $users = $this->paginate($this->Users->find('all')->contain('Roles'), [
      'limit' => $limit,
      'order' => [
        'Users.created' => 'DESC'
      ]
    ]);

    $this->set(compact('users'));
    $this->set('_serialize', ['users']);

    return NULL;
  }

  /**
   * View method.
   *
   * @param null $id
   *   Entity id.
   *
   * @return bool
   */
  public function view($id = null) {
    $user = $this->Users->get($id);
    $this->set(compact('user'));

    if (empty($user)) {
      $this->goHome();
    }

    return NULL;
  }

  /**
   * Profile method.
   *
   * @param int $limit
   *   Limit records per page.
   *
   * @return bool
   */
  public function profile($limit = 10) {
    $userId = $this->Auth->user('id');

    $this->view($userId);

    $articles = $this->paginate(
      $this->Articles->find('all')->contain(['Users', 'Images']), [
        'conditions' => ['user_id' => $userId],
        'limit' => $limit,
        'order' => [
          'Articles.created' => 'DESC',
        ]
      ]
    );

    $this->set(compact('articles'));
    $this->set('_serialize', ['articles']);

    return NULL;
  }

  /**
   * Create Auth method.
   *
   * @param $user
   *   User object.
   *
   * @return mixed
   */
  public function createAuth($user) {
    if ($user) {
      $this->Auth->setUser($user);
      $log = 'User with alias `' . $user['alias'] . '` login.';
      $this->setLog($log);
      $this->redirect($this->Auth->redirectUrl());

      return TRUE;
    }

    return FALSE;
  }

  /**
   * Login method.
   *
   * @param $user
   *   User object.
   *
   * @return mixed
   */
  public function login($user = NULL) {

    if ($this->request->is('post') && $user === NULL) {
      $user = $this->Auth->identify();

      // Redirect if success.
      $this->createAuth($user);

      $log = 'Invalid alias or password, try again';
      $this->setLog($log);
      $this->Flash->error(__($log));

    } else {
      $user = $this->Auth->identify();

      $this->createAuth($user);
    }

    return NULL;
  }

  /**
   * Logout method.
   *
   * @return \Cake\Http\Response|null
   */
  public function logout() {
    $log = 'User with alias `' . $this->user_alias . '` logout`.';
    $this->setLog($log);

    return $this->redirect($this->Auth->logout());
  }

  /**
   * Sign up method.
   */
  public function signUp() {
    $this->add('login');
  }

  /**
   * Add method.
   *
   * @param string $redirect
   *   Redirect param.
   *
   * @return mixed
   */
  public function add($redirect = 'index') {
    $user = $this->Users->newEntity();

    $this->getRoleList();

    if ($this->request->is('post')) {

      $user = $this->Users->patchEntity($user, $this->request->getData());

      if ($this->Users->save($user)) {

        $log = 'User with `' . $user['alias'] . '` alias have been created.';
        $this->setLog($log);
        $this->Flash->success(__($log));

        if ($redirect == 'login') {
          $this->login($user);
        }

        $this->redirect(['action' => $redirect]);

      } else {

        $log = 'Unable to save user.';
        $this->setLog($log);
        $this->Flash->error(__($log));

      }
    }
    $this->set('user', $user);

    return NULL;
  }

  /**
   * Edit method.
   *
   * @param null $id
   *   Entity ID.
   *
   * @return mixed
   */
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

    return NULL;
  }

  /**
   * Delete method.
   *
   * @param $id
   *   Entity ID.
   * @return mixed
   */
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

    return NULL;
  }

  /**
   * Gets role list method.
   */
  private function getRoleList() {
    $roles = $this->Roles->find('all');
    foreach ($roles as $role) {
      $role_name[$role->id] = $role->role_name;
    }
    $this->set(compact('role_name'));
  }

}