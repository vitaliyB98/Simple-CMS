<h1><?= __('Edit role') ?></h1>
<?= $this->element('/admintabs'); ?>
<?php
    echo $this->Form->create($role);
    echo $this->Form->control('role_name');
    echo $this->Form->submit('Edit', array('class' => 'btn-theme'));
    echo $this->Form->end();
?>