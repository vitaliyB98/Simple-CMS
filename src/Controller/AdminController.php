<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 29.05.17
 * Time: 12:33
 */
namespace App\Controller;

use Cake\Event\Event;

class AdminController extends AppController {

  /**
   * Index method.
   */
  public function index() {
    $this->redirect(['controller' => 'Logs', 'action' => 'index']);
  }

  /**
   * Before render method.
   *
   * @param $event
   *
   * @return bool
   */
  public function beforeRender(Event $event) {
    parent::beforeRender($event);
    if (isset($this->role) && ($this->role ==! 3)) {
      return FALSE;
    }
  }

}
