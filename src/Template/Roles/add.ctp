<h1><?= __('Create role') ?></h1>
<?= $this->element('/admintabs'); ?>
<?php
    echo $this->Form->create($role);
    echo $this->Form->input('role_name', ['type' => 'text']);
    echo $this->Form->submit('Create', array('class' => 'btn-theme'));
    echo $this->Form->end();
?>
