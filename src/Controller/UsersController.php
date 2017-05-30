<?php

namespace App\Controller;

class UsersController extends AppController {
  public function index() {
    $users = $this->Users->find('all');
    $this->set(compact('users'));
  }

  public function view($id = null) {
    $user = $this->Users->get($id);
    $this->set(compact('user'));
  }
}