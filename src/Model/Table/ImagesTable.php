<?php
/**
 * Created by PhpStorm.
 * User: Fencer
 * Date: 01.06.17
 * Time: 15:52
 */
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ImagesTable extends Table {
  public function initialize(array $config) {
    $this->addBehavior('Timestamp');
  }

  public function validationDefault(Validator $validator) {

    return $validator;
  }
}