<h1>Add Article</h1>
<?php
    echo $this->Form->create($article, ['enctype' => 'multipart/form-data']);
    echo $this->Form->input('title', array('type' => 'text'));
    echo $this->Form->input('body', array('type' => 'textarea', 'rows' => 3));
    echo $this->CKEditor->replace('body');
    echo $this->Form->input('Put your image', ['type' => 'file']);
    echo $this->Form->submit('Save', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
?>