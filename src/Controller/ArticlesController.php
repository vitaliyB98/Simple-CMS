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

  /**
   * Initialize method.
   */
  public function initialize() {
    parent::initialize();

    $this->loadModel('Users');
    $this->loadModel('Images');
  }

  /**
   * Before filter method.
   *
   * @param $event
   *   Object.
   *
   * @return bool
   */
  public function beforeFilter(Event $event) {
    parent::beforeFilter($event);

    return NULL;
  }

  /**
   * Before render method.
   *
   * @param $event
   *   Object.
   *
   * @return bool
   *    Access status.
   */
  public function beforeRender(Event $event) {
    parent::beforeRender($event);
    // The owner of an article can edit and delete it.
    if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
      $entityId = $this->getEntityId();
      if ($this->isOwnedBy($entityId, $this->user_id)) {
        return TRUE;
      }
    }

    if (in_array($this->request->getParam('action'), ['index', 'view', 'add']) || $this->role === 3) {
      return TRUE;
    }

    $this->goHome();
    return TRUE;
  }

  /**
   * It`s user owner?
   *
   * @param int $entityId
   *   Entity ID.
   * @param int $userId
   *   User ID.
   *
   * @return mixed
   *   Is owned by?
   */
  private function isOwnedBy($entityId, $userId) {
    return $this->Articles->exists(['id' => $entityId, 'user_id' => $userId]);
  }

  /**
   * Index method.
   *
   * @param int $limit
   *   Limit records.
   *
   * @return bool
   */
  public function index($limit = 6) {

    $articles = $this->paginate(
      $this->Articles->find('all')->contain(['Users', 'Images']), [
        'limit' => $limit,
        'order' => [
          'Articles.created' => 'DESC',
        ],
      ]
    );
    $this->set('secret_key', $this->Cookie->read('secret_key'));
    $this->set(compact('articles'));
    $this->set('_serialize', ['articles']);

    return NULL;
  }

  /**
   * View method.
   *
   * @param int $id
   *   Entity id.
   *
   * @return bool
   */
  public function view($id = 1) {
    $article = $this->Articles->find('all', [
      'conditions' => [
        'Articles.id' => $id,
      ],
    ])->contain(['Images', 'Users']);

    $article->hydrate(false);
    $article = $article->toArray();
    $article = $article[0];

    if (empty($article)) {
      $this->goHome();
    }

    $this->set(compact('article'));
    return NULL;
  }

  /**
   * Table list method.
   *
   * @return bool
   */
  public function tableList() {
    $this->index(10);

    return NULL;
  }

  /**
   * Add articles method.
   *
   * @return mixed
   */
  public function add() {
    $article = $this->Articles->newEntity();

    // Save image.
    if (isset($_FILES['Put_your_image']['name']) && !empty($_FILES['Put_your_image']['name'])) {
      if ( !($article->image_id = $this->uploadImg()) ) {
        $log = 'Unable to create article.';
        $this->setLog($log);
        $this->Flash->error(__($log));
        return $this->redirect(['action' => 'tableList']);
      }
    }

    if ($this->request->is('post')) {
      $article = $this->Articles->patchEntity($article, $this->request->getData());

      // User which create article.
      $article->user_id = $this->Auth->user('id');

      if ($this->Articles->save($article)) {
        $log = 'Your article has been saved.';
        $this->setLog($log);
        $this->Flash->success(__($log));

        return $this->redirect(['action' => 'tableList']);
      }
      $log = 'Unable to add your article.';
      $this->setLog($log);
      $this->Flash->error(__($log));
    }
    $this->set('article', $article);
    return NULL;
  }

  /**
   * Edit method.
   *
   * @param null $id
   *   Entity id.
   * @return mixed
   */
  public function edit($id = null) {
    $article = $this->Articles->get($id);
    $img_id = $article->image_id;

    // Save image.
    if (isset($_FILES['Put_your_image']['name']) && !empty($_FILES['Put_your_image']['name'])) {
      if ( !($article->image_id = $this->uploadImg()) ) {
        $log = 'Unable to create article.';
        $this->setLog($log);
        $this->Flash->error(__($log));
        return $this->redirect(['action' => 'tableList']);

      } else {

        // If new photo save successfully, we delete old photo.
        if (!empty($img_id)) {
          // Find img name.
          $image = $this->Images->get($img_id);
          $img_delete = $image->img_name;

          // Delete img which we change.
          $this->Images->delete($image);
          unlink(WWW_ROOT . $img_delete);
        }

      }
    }

    if ($this->request->is(['post', 'put'])) {
      $this->Articles->patchEntity($article, $this->request->getData());
      if ($this->Articles->save($article)) {
        $log = 'Your article has been updated.';
        $this->setLog($log);
        $this->Flash->success(__($log));
        return $this->redirect(['action' => 'tableList']);
      }
      $log = 'Unable to update your article';
      $this->setLog($log);
      $this->Flash->error(__($log));
    }
    $this->set('article', $article);
    return NULL;
  }

  /**
   * Delete method.
   *
   * @param int $id
   *   Entity id.
   * @return mixed
   */
  public function delete($id) {
    $this->request->allowMethod(['post', 'delete']);

    $article = $this->Articles->get($id);
    $img_id = $article->image_id;

    // Find img name.
    if ($img_id != 0) {
      $image = $this->Images->get($img_id);
      $image_name = $image->img_name;
    }


    if ($this->Articles->delete($article)) {
      if (!empty($image_name) && isset($image)) {
        unlink(WWW_ROOT . $image_name);
        $this->Images->delete($image);
      }
      $log = 'The article with id: ' . $id . ' has been deleted.';
      $this->setLog($log);
      $this->Flash->success(__($log));

      return $this->redirect(['action' => 'tableList']);
    }

    return NULL;
  }

  /**
   * Upload image from form method.
   *
   * @return mixed
   *   If img save successfully return id.
   */
  private function uploadImg() {
    $files = $_FILES['Put_your_image'];
    $file_name = time() . rand(0, 9999) . $files['name'];

    $allow_ext = ['png', 'jpg', 'jpeg', 'gif'];
    // Get file extension.
    $file_ext =  substr(strrchr($file_name, '.'), 1);

    if (!in_array($file_ext, $allow_ext)) {
      $log = 'You can upload only ' . implode(", ", $allow_ext) . ' file.';
      $this->setLog($log);
      $this->Flash->error(__($log));
      return FALSE;
    }

    if ($files['size'] > 3000000) {
      $log = 'You can upload image less than 3 MB';
      $this->setLog($log);
      $this->Flash->error(__($log));
      return FALSE;
    }

    $old_path = $files['tmp_name'];
    $abs_path = WWW_ROOT . 'img/user_upload/article/' . $file_name;
    $rel_path = '/img/user_upload/article/' . $file_name;

    if (move_uploaded_file($old_path, $abs_path)) {
      $img = $this->Images->newEntity();
      $img->img_name = $rel_path;

      if ($this->Images->save($img)) {
        return $img->id;
      }
    }
    $log = 'Unable to save file. Something wrong with saving =(';
    $this->setLog($log);
    $this->Flash->error(__($log));

    return FALSE;
  }
}
