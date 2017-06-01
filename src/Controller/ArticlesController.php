<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 26.05.17
 * Time: 18:20
 */

namespace App\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class ArticlesController extends AppController {

  public function initialize() {
    parent::initialize();

    $this->loadModel('Users');
    $this->loadModel('Images');
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
    $this->index(10);
  }

  public function add() {
    $article = $this->Articles->newEntity();

    // Save image.
    if (isset($_FILES['Put_your_image']['name']) && !empty($_FILES['Put_your_image']['name'])) {
      if ( !($article->img_id = $this->uploadImg()) ) {
        $this->Flash->error(__('Unable to create article.'));
        return $this->redirect(['action' => 'tableList']);
      }
    }

    if ($this->request->is('post')) {
      $article = $this->Articles->patchEntity($article, $this->request->getData());

      // User which create article.
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

    // Save image.
    if (isset($_FILES['Put_your_image']['name']) && !empty($_FILES['Put_your_image']['name'])) {
      if ( !($article->img_id = $this->uploadImg()) ) {
        $this->Flash->error(__('Unable to create article.'));
        return $this->redirect(['action' => 'tableList']);
      }
    }

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

  /**
   * Upload image from form.
   */
  public function uploadImg() {
    $files = $_FILES['Put_your_image'];
    $file_name = time() . rand(0, 9999) . $files['name'];

    $allow_ext = ['png', 'jpg', 'jpeg', 'gif'];
    // Get file extension.
    $file_ext =  substr(strrchr($file_name, '.'), 1);

    if (!in_array($file_ext, $allow_ext)) {
      $this->Flash->error(__('You can upload only ' . implode(", ", $allow_ext) . ' file.'));
      return FALSE;
    }

    if ($files['size'] > 3000000) {
      $this->Flash->error(__('You can upload image less than 3 MB'));
      return FALSE;
    }

    $old_path = $files['tmp_name'];
    $new_path = WWW_ROOT . '/img/user_upload/article/' . $file_name;

    if (move_uploaded_file($old_path, $new_path)) {
      $img = $this->Images->newEntity();
      $img->img_name = $file_name;

      if ($this->Images->save($img)) {
        return $img->id;
      }
    }
    $this->Flash->error(__('Unable to save file. Something wrong with saving =('));

    return FALSE;
  }
}
