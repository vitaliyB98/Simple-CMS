<div class = "users form">
    <?= $this->Form->create($user) ?>
        <fieldset>
            <legend>Edit</legend>
            <?php
                echo $this->Form->input('name', ['type' => 'text', 'class' => 'form-control']);
                echo $this->Form->input('alias', ['type' => 'text', 'class' => 'form-control']);
                echo $this->Form->input('email', ['type' => 'email', 'class' => 'form-control']);
                echo $this->Form->input('password', ['type' => 'password', 'class' => 'form-control']);
                echo $this->Form->input('birth', [
                    'label' => 'Date of birth',
                    'minYear' => date('Y') - 70,
                    'maxYear' => date('Y') - 16,
                ]);
                if ($role === 3) {
                    echo $this->Form->input('role_id', array(
                    'options' => $role_name,
                    ));
                }
                echo $this->Form->submit('Edit', array('class' => 'btn-form'));
            ?>
        </fieldset>
    <?= $this->Form->end() ?>

</div>
