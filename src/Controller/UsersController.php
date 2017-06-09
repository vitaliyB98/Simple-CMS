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
   *
   * @param $event
   *   Event object.
   *
   * @return bool
   */
  public function beforeFilter(Event $event) {
    parent::beforeFilter($event);

    return NULL;
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

      // Remember me function.
      $this->rememberMe($user);

      $this->Auth->setUser($user);
      $log = 'User with alias `' . $user['alias'] . '` login.';
      $this->setLog($log);
      $this->redirect($this->Auth->redirectUrl());

      return TRUE;
    }

    return FALSE;
  }

  /**
   * Remember me method.
   */
  public function rememberMe($user) {
    if (!empty($_POST['remember_me']) && ($_POST['remember_me'] === "1")) {

      $user_object = $this->Users->get($user['id']);
      $hash = bin2hex(openssl_random_pseudo_bytes(75));
      $user_object->secret_key = $hash;
      $this->Cookie->write('secret_key', $hash, false, 60*60*24*30);

      $this->Users->save($user_object);
    }
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

    if (!empty($this->Cookie->read('secret_key'))) {
      $user = $this->Users->find('all', [
        'conditions' => [
          'Users.secret_key' => $this->Cookie->read('secret_key')
        ]
      ]);

      $user->hydrate(false);
      $user = $user->toArray();
      $user = array_shift($user);
      if (!empty($user)) {
        $this->createAuth($user);
      }

    }

    if ($this->request->is('post') && $user === NULL) {
      $user = $this->Auth->identify();

      // Redirect if success.
      if (!$this->createAuth($user)) {
        $log = 'Invalid alias or password, try again';
        $this->setLog($log);
        $this->Flash->error(__($log));
      }

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
    $this->Cookie->delete('secret_key');

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
    if (empty($_GET['param'])) {
      $log = 'Someone want delete users without your permission';
      $this->setLog($log);

      $this->goHome();
      return NULL;
    }

    // Check conditions.
    $check_param = ($_GET['param'] === '13p5798e64y2') || ($_GET['param'] === '24e68p97o53n1');
    $check_role = $this->role === 3;

    if ($check_param && $check_role) {

      if ($_GET['param'] === '13p5798e64y2') {
        $articles = $this->Articles->find('all', [
          'conditions' => [
            'Articles.user_id' => $id,
          ],
        ]);

        // Delete all articles for users.
        foreach ($articles as $article) {
          $article = $this->Articles->get($article->id);
          $this->Articles->delete($article);
        }
      }

      $user = $this->Users->get($id);

      if ($this->Users->delete($user)) {
        $log = 'The user with id: ' . $id . ' has been deleted.';
        $this->setLog($log);
        $this->Flash->success(__($log));

        return $this->redirect(['action' => 'index']);
      }
    } else {
      $log = 'Someone want delete users without your permission (has param)';
      $this->setLog($log);

      $this->goHome();
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