<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 26.05.17
 * Time: 14:21
 */
// src/Model/Entity/Article.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Article extends Entity {
  protected $_accessible = [
    '*' => TRUE,
    'id' => FALSE,
  ];
}