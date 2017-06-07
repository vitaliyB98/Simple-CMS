<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     * User params.
     */
    protected $role;
    protected $user_id;
    protected $user_alias;

    /**
     * Include WYSIWYG.
     */
    public $helpers = ['AkkaCKEditor.CKEditor'];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
      parent::initialize();

      $this->loadModel('Logs');
      $this->loadComponent('RequestHandler');
      $this->loadComponent('Flash');
      $this->loadComponent('Auth', [
        'authenticate' => [
          'Form' => [
            'fields' => [
              'username' => 'alias',
              'password' => 'password',
            ],
          ],
        ],
        'loginRedirect' => [
          'controller' => 'Articles',
          'action' => 'index',
        ],
        'logoutRedirect' => [
          'controller' => 'Users',
          'action' => 'login',
        ],
      ]);
      $this->Auth->allow(['login', 'logout', 'signup']);
      /**
       * Enable the following components for recommended CakePHP security settings.
       * see http://book.cakephp.org/3.0/en/controllers/components/security.html
       */
      //$this->loadComponent('Security');
      //$this->loadComponent('Csrf');

      $this->role = $this->getRole();
      $this->user_alias = $this->getAlias();
      $this->user_id = $this->getUserId();
    }

    /**
     * Before Filter method.
     *
     * @param $event
     *   Event object.
     *
     * @return object
     *    Event object.
     */
    public function beforeFilter(Event $event) {

      $this->set([
        'role' => $this->role,
        'user_alias' => $this->user_alias
      ]);

      return parent::beforeFilter($event);
    }

    /**
     * Before Render method.
     *
     * @param $event
     *
     * @return bool
     */
    public function beforeRender(Event $event) {
      if (!array_key_exists('_serialize', $this->viewVars) &&
          in_array($this->response->type(), ['application/json', 'application/xml'])
      ) {
          $this->set('_serialize', TRUE);
      }

      // Method for admin allowed.
      if (isset($this->role) && ($this->role === 3)) {
        return TRUE;
      }
      return FALSE;
    }

    /**
     * Gets summary method.
     *
     * @param $text
     *   Text for summary.
     * @param $word_limit
     *   Number words.
     *
     * @return string
     *   Summary.
     */
    static public function summary($text, $word_limit) {
      $words = explode(" ",$text);
      $word_limit === $words ? $end = '' : $end = ' ...';
      return implode(" ",array_splice($words,0,$word_limit)) . $end;
    }

    /**
     * Go home method.
     */
    public function goHome() {
      $this->redirect(['controller' => 'Pages', 'action' => 'display']);
    }

    /**
     * Set log method.
     *
     * @param string $text_log
     *   Text log.
     */
    public function setLog($text_log = 'error') {
      $log = $this->Logs->newEntity();
      $log->body_log = $text_log;
      $log->user_id = $this->user_id;
      $this->Logs->save($log);
    }

    /**
     * Get entity id method.
     *
     * @return int
     *    Entity id from request.
     */
    protected function getEntityId() {
      return (int)$this->request->getParam('pass.0');
    }

    /**
     * Is exist method.
     *
     * @param $modelName
     *   Table name.
     * @param $property
     *   Property.
     * @param $value
     *   Value.
     *
     * @return mixed
     *   Exist status.
     */
    protected function isExist($modelName, $property, $value) {
      $fancyTable = TableRegistry::get($modelName);
      $exists = $fancyTable->exists([$property => $value]);

      return $exists;
    }

    /**
     * Get users role method.
     *
     * @return int
     *   Role id.
     */
    private function getRole() {
      if (!empty($this->Auth->user('role_id'))) {
        return $this->Auth->user('role_id');
      }
      return 0;
    }

    /**
     * Get users alias method.
     *
     * @return string
     *    User alias.
     */
    private function getAlias() {
      if (!empty($this->Auth->user('alias'))) {
        return $this->Auth->user('alias');
      }
      return 'Guest';
    }

    /**
     * Get users id method.
     *
     * @return mixed
     *    User id if exist.
     */
    private function getUserId() {
      if ($this->Auth->user('id')) {
        return $this->Auth->user('id');
      }
      return FALSE;
    }

}
