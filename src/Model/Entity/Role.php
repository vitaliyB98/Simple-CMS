<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 31.05.17
 * Time: 10:29
 */

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Role extends Entity {

  protected $_accessible = [
    '*' => TRUE,
    'id' => FALSE,
  ];

}
