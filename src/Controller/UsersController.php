<?php

namespace App\Controller;


class UsersController extends AppController {

  public function initialize() {
    parent::initialize();
    $this->loadModel('Roles');
    $this->loadComponent('Flash'); // Include the FlashComponent
  }

  public function index() {
    $users = $this->Users->find('all');
    $this->set(compact('users'));
  }

  public function view($id = null) {
    $user = $this->Users->get($id);
    $this->set(compact('user'));
  }

  public function add() {
    $user = $this->Users->newEntity();

    $this->getRole();

    if ($this->request->is('post')) {
      $user = $this->Users->patchEntity($user, $this->request->getData());
      if ($this->Users->save($user)) {
        $this->Flash->success(__('User have been created.'));

        $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('Unable to save user.'));
      }
    }
    $this->set('user', $user);
  }

  public function edit($id = null) {
    $user = $this->Users->get($id);

    $this->getRole();

    if ($this->request->is(['post', 'put'])) {
      $this->Users->patchEntity($user, $this->request->getData());
      if ($this->Users->save($user)) {
        $this->Flash->success(__('Your user has been updated.'));
        return $this->redirect(['action' => 'index']);
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
  public function getRole() {
    $roles = $this->Roles->find('all');
    foreach ($roles as $role) {
      $role_name[$role->id] = $role->role_name;
    }
    $this->set(compact('role_name'));
  }
}