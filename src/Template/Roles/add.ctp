<h1>Create role</h1>

<?php
    echo $this->Form->create($role);
    echo $this->Form->input('role_name', ['type' => 'text']);
    echo $this->Form->submit('Create', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
?>
