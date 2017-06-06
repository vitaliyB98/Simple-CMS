<div class = "users form">
    <?= $this->Form->create($user) ?>
        <fieldset>
            <legend>Edit</legend>
            <?php
                echo $this->Form->input('name', ['type' => 'text']);
                echo $this->Form->input('alias', ['type' => 'text']);
                echo $this->Form->input('email', ['type' => 'email']);
                echo $this->Form->input('password', ['type' => 'password']);
                echo $this->Form->input('birth', [
                    'label' => 'Date of birth',
                    'minYear' => date('Y') - 70,
                    'maxYear' => date('Y') - 16,
                ]);
                if ($role === 3) {
                    echo $this->Form->input('role', array(
                    'options' => $role_name,
                    ));
                }
                echo $this->Form->submit('Edit', array('class' => 'btn btn-primary'));
            ?>
        </fieldset>
    <?= $this->Form->end() ?>

</div>
