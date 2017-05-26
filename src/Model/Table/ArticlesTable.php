<?php
/**
 * Created by PhpStorm.
 * User: fencer
 * Date: 26.05.17
 * Time: 18:11
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class ArticlesTable extends Table {
  public function initialize(array $config) {
    $this->addBehavior('Timestamp');
  }
}