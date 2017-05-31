<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 31.05.17
 * Time: 10:30
 */

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class RolesTable extends Table {
  public function initialize(array $config) {
    $this->addBehavior('Timestamp');
  }

  public function validationDefault(Validator $validator) {
    $validator
      ->notEmpty('role_name')
      ->requirePresence('role_name');
    return $validator;
  }
}