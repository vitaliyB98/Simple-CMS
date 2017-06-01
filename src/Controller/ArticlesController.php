<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 26.05.17
 * Time: 18:20
 */

namespace App\Controller;
use Cake\Event\Event;

class ArticlesController extends AppController {

  public function initialize() {
    parent::initialize();

    $this->loadModel('Users');
    $this->loadComponent('Flash'); // Include the FlashComponent
    $this->loadComponent('Paginator');
  }

  /**
   * Before filter.
   */
  public function beforeFilter(Event $event) {
    parent::beforeFilter($event);
    $this->Auth->allow(['index', 'view']);
  }

  public function index($limit = 4) {

    empty($_GET['sort_by']) ? $sort_by = 'Articles.created' : $sort_by = $_GET['sort_by'];
    empty($_GET['type_sort']) ? $type_sort = 'DESC' : $type_sort = $_GET['type_sort'];

    if (empty($sort_by)) {
      $sort_by = 'Articles.created';
    }

    if (empty($type_sort)) {
      $sort_by = 'DESC';
    }

    $users = $this->Articles->find('all', [
      'condition' => ['Articles.user_id = Users.id'],
      'limit' => $limit,
      'order' => [
        'Articles.created' => 'DESC',
      ]
    ])->contain(['Users']);
    $users->hydrate(false);
    $users = $users->toArray();
    $this->set(compact('users'));

    $this->set('articles', $this->Paginator->paginate($this->Articles->find('all')->contain(['Users']), [
        'condition' => ['Articles.user_id = Users.id'],
        'limit' => $limit,
        'order' => [
          $sort_by => $type_sort,
        ]
      ]
    ));
  }

  public function view($id = 1) {
    $article = $this->Articles->get($id);
    $this->set(compact('article'));
  }

  public function tableList() {
    $this->index(5);
  }

  public function add() {
    $article = $this->Articles->newEntity();
    if ($this->request->is('post')) {
      $article = $this->Articles->patchEntity($article, $this->request->getData());
      // Added this line.
      $article->user_id = $this->Auth->user('id');
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
