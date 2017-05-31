<h1>Edit Role</h1>
<?php
    echo $this->Form->create($role);
    echo $this->Form->control('role_name');
    echo $this->Form->button(__('Save Role'));
    echo $this->Form->end();
?>