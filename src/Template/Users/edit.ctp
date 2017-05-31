<h1>Edit user</h1>

<?php
    echo $this->Form->create($user);
    echo $this->Form->input('name', ['type' => 'text']);
    echo $this->Form->input('alias', ['type' => 'text']);
    echo $this->Form->input('email', ['type' => 'email']);
    echo $this->Form->input('password', ['type' => 'password']);
    echo $this->Form->input('role', array(
    'options' => $role_name,
    ));
    echo $this->Form->submit('Edit', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
?>
