<h1>Add Article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->input('title', array('type' => 'text'));
    echo $this->Form->input('body', array('type' => 'textarea', 'rows' => 3));
    echo $this->CKEditor->replace('body');
    echo $this->Form->submit('Save', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
?>