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
   * {@inheritdoc}
   */
  public function index() {

  }

  /**
   * {@inheritdoc}
   */
  public function beforeRender(Event $event) {
    parent::beforeRender($event);
    if (isset($this->role) && ($this->role ==! 3)) {
      return FALSE;
    }
  }

}
