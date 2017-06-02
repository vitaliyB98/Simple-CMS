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

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
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
            'controller' => 'Pages',
            'action' => 'display',
          ],
          'logoutRedirect' => [
            'controller' => 'Pages',
            'action' => 'display',
          ],
        ]);
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
      $role = $this->Auth->user('role');
      $user_alias = $this->Auth->user('alias');

      $this->set(compact('role', 'user_alias'));

      return parent::beforeFilter($event);
    }


  public function isAuthorized($user) {
      // Admin can access every action.
      if (isset($user['role']) && $user['role'] === 3) {
        return true;
      }
      return false;
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

  /**
   * Gets summary.
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

}
