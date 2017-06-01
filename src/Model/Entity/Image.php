<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 01.06.17
 * Time: 15:52
 */
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Image extends Entity {

  protected $_accessible = [
    '*' => TRUE,
    'id' => FALSE,
  ];

}
