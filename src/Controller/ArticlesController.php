<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 26.05.17
 * Time: 14:24
 */
// src/Controller/ArticlesController.php
namespace App\Controller;

class ArticlesController extends AppController{

  public function index() {
    $articles = $this->Articles->find('all');
    $this->set(compact('articles'));
  }
}