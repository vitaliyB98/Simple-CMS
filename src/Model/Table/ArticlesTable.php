<?php
/**
 * Created by PhpStorm.
 * User: fencer
 * Date: 26.05.17
 * Time: 18:11
 */

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ArticlesTable extends Table {
  public function initialize(array $config) {
    $this->addBehavior('Timestamp');
  }

  public function validationDefault(Validator $validator) {
    $validator
      ->notEmpty('title')
      ->requirePresence('title')
      ->notEmpty('body')
      ->requirePresence('body');
    return $validator;
  }
}