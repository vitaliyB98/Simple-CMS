<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 26.05.17
 * Time: 18:20
 */

namespace App\Controller;

class ArticlesController extends AppController {
  public function initialize() {
    parent::initialize();

    $this->loadComponent('Flash'); // Include the FlashComponent
  }

  public function index() {
    $articles = $this->Articles->find('all')->order(['created' => 'DESC']);
    $this->set(compact('articles'));
  }

  public function view($id = 1) {
    $article = $this->Articles->get($id);
    $this->set(compact('article'));
  }

  public function tableList() {
    $this->index();
  }

  public function add() {
    $article = $this->Articles->newEntity();
    if ($this->request->is('post')) {
      $article = $this->Articles->patchEntity($article, $this->request->getData());
      if ($this->Articles->save($article)) {
        $this->Flash->success(__('Your article has been saved.'));

        return $this->redirect(['action' => 'tableList']);
      }
      $this->Flash->error(__('Unable to add your article.'));
    }
    $this->set('article', $article);
  }

  public function edit($id = null) {
    $article = $this->Articles->get($id);
    if ($this->request->is(['post', 'put'])) {
      $this->Articles->patchEntity($article, $this->request->getData());
      if ($this->Articles->save($article)) {
        $this->Flash->success(__('Your article has been updated.'));
        return $this->redirect(['action' => 'tableList']);
      }
      $this->Flash->error(__('Unable to update your article'));
    }
    $this->set('article', $article);
  }

  public function delete($id) {
    $this->request->allowMethod(['post', 'delete']);

    $article = $this->Articles->get($id);
    if ($this->Articles->delete($article)) {
      $this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));

      return $this->redirect(['action' => 'tableList']);
    }
  }
}
