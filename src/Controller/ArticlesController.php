<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 26.05.17
 * Time: 18:20
 */

namespace App\Controller;

class ArticlesController extends AppController {
  public function index() {
    $articles = $this->Articles->find('all');
    $this->set(compact('articles'));
  }

  public function view($id = 1) {
    $article = $this->Articles->get($id);
    $this->set(compact('article'));
  }

}
