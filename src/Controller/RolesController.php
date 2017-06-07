<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 31.05.17
 * Time: 10:29
 */
namespace App\Controller;

use Cake\Event\Event;

class RolesController extends AppController {

  /**
   * Initialize method.
   */
  public function initialize() {
    parent::initialize();
    $this->loadComponent('Flash');
  }

  /**
   * Before render method.
   *
   * @param $event
   *   Event object.
   *
   * @return bool
   */
  public function beforeRender(Event $event) {
    parent::beforeRender($event);
    if ($this->role !== 3) {
      $this->goHome();
    }

    return TRUE;
  }

  /**
   * Index method.
   *
   * @return bool
   */
  public function index() {
    $roles = $this->paginate($this->Roles);

    $this->set(compact('roles'));
    $this->set('_serialize', ['roles']);

    return NULL;
  }

  /**
   * Add method.
   *
   * @return bool
   */
  public function add() {
    $role = $this->Roles->newEntity();

    if ($this->request->is('post')) {
      $role = $this->Roles->patchEntity($role, $this->request->getData());
      if ($this->Roles->save($role)) {
        $log = 'Role have been created.';
        $this->setLog($log);
        $this->Flash->success(__($log));

        $this->redirect(['action' => 'index']);
      } else {
        $log = 'Unable to save role.';
        $this->setLog($log);
        $this->Flash->error(__($log));
      }
    }
    $this->set('role', $role);

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
  public function edit($id = null) {
    $role = $this->Roles->get($id);
    if ($this->request->is(['post', 'put'])) {
      $this->Roles->patchEntity($role, $this->request->getData());
      if ($this->Roles->save($role)) {
        $log = 'Your role has been updated.';
        $this->setLog($log);
        $this->Flash->success(__($log));
        return $this->redirect(['action' => 'index']);
      }
      $log = 'Unable to update your role';
      $this->setLog($log);
      $this->Flash->error(__($log));
    }
    $this->set('role', $role);

    return NULL;
  }

  /**
   * Delete method.
   *
   * @param $id
   *   Entity Id.
   *
   * @return mixed
   */
  public function delete($id) {
    $this->request->allowMethod(['post', 'delete']);

    $role = $this->Roles->get($id);
    if ($this->Roles->delete($role)) {
      $log = 'The role with id: ' . $id . ' has been deleted.';
      $this->setLog($log);
      $this->Flash->success(__($log));

      return $this->redirect(['action' => 'index']);
    }

    return NULL;
  }
}