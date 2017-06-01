<h1>Edit Article</h1>

<?php
    echo $this->Form->create($article, ['enctype' => 'multipart/form-data']);
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '3']);
    echo $this->CKEditor->replace('body');
    echo $this->Form->input('Put your image', ['type' => 'file']);
    echo $this->Form->submit('Edit', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
?>