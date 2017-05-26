<?php
/**
 * Created by PhpStorm.
 * User: Fecner
 * Date: 26.05.17
 * Time: 14:16
 */
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class ArticlesTable extends Table {
  public function initialize(array $config) {
    $this->addBehavior('Timestamp');
  }
}
