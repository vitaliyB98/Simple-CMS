<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 30.05.17
 * Time: 18:54
 */
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table {
  public function initialize(array $config) {
    $this->addBehavior('Timestamp');
  }

  public function validationDefault(Validator $validator) {
    $validator
      ->notEmpty('email')
      ->requirePresence('email')
      ->notEmpty('password')
      ->requirePresence('password');

    return $validator;
  }
}