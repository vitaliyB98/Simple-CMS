<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 30.05.17
 * Time: 18:56
 */

namespace App\Model\Entity;

use Cake\ORM\Entity;

class User extends Entity {
  protected $_accessible = [
    '*' => true,
    'id' => false,
  ];
}