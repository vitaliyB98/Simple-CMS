<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 31.05.17
 * Time: 10:29
 */
namespace App\Controller;

class RolesController extends AppController {

  public function initialize() {
    parent::initialize();

    $this->loadComponent('Flash'); // Include the FlashComponent
  }

  public function index() {
    $roles = $this->Roles->find('all');
    $this->set(compact('roles'));
  }

  public function add() {
    $role = $this->Roles->newEntity();

    if ($this->request->is('post')) {
      $role = $this->Roles->patchEntity($role, $this->request->getData());
      if ($this->Roles->save($role)) {
        $this->Flash->success(__('Role have been created.'));

        $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('Unable to save role.'));
      }
    }
    $this->set('role', $role);
  }

  public function edit($id = null) {
    $role = $this->Roles->get($id);
    if ($this->request->is(['post', 'put'])) {
      $this->Roles->patchEntity($role, $this->request->getData());
      if ($this->Roles->save($role)) {
        $this->Flash->success(__('Your role has been updated.'));
        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('Unable to update your role'));
    }
    $this->set('role', $role);
  }

  public function delete($id) {
    $this->request->allowMethod(['post', 'delete']);

    $role = $this->Roles->get($id);
    if ($this->Roles->delete($role)) {
      $this->Flash->success(__('The role with id: {0} has been deleted.', h($id)));

      return $this->redirect(['action' => 'index']);
    }
  }
}