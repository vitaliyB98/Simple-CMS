<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 30.05.17
 * Time: 18:56
 */

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity {
  protected $_accessible = [
    '*' => true,
    'id' => false,
  ];

  protected function _setPassword($password) {
    if (strlen($password) > 0) {
      return (new DefaultPasswordHasher)->hash($password);
    }
  }

}