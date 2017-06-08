<h1><?= __('Edit article') ?></h1>
<?= $this->element('/admintabs'); ?>
<?php
    echo $this->Form->create($article, ['enctype' => 'multipart/form-data']);
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '3']);
    echo $this->CKEditor->replace('body');
    echo $this->Form->input('Put your image', ['type' => 'file']);
    echo $this->Form->submit('Edit', array('class' => 'btn-theme'));
    echo $this->Form->end();
?>