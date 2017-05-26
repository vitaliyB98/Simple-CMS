<?php
/**
 * Created by PhpStorm.
 * User: fencer
 * Date: 26.05.17
 * Time: 18:15
 */

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Article extends Entity {

  protected $_accessible = [
    '*' => TRUE,
    'id' => FALSE,
  ];

}
