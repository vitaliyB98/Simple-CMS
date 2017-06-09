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
    $this->belongsTo('Roles');
    $this->hasMany('Articles');
  }

  public function validationDefault(Validator $validator) {
    $validator
      ->notEmpty('name')
      ->requirePresence('name')
      ->notEmpty('alias')
      ->requirePresence('alias')
      ->add('alias', [
        'unique' => [
          'rule' => 'validateUnique',
          'provider' => 'table',
          'message' => 'Your alias is`nt unique.',
        ]
      ])
      ->notEmpty('email')
      ->requirePresence('email')
      ->notEmpty('password')
      ->requirePresence('password')
      ->add('password', [
        'length' => [
          'rule' => ['minLength', 3],
          'message' => 'Password need to be at least 3 characters.'
        ]
      ]);

    return $validator;
  }
}