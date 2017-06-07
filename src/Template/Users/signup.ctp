<div class = "users form">
    <?= $this->Form->create($user) ?>
        <fieldset>
            <h2>Sign up</h2>
            <?php
                echo $this->Form->input('name', ['type' => 'text', 'class' => 'form-control']);
                echo $this->Form->input('alias', ['type' => 'text', 'class' => 'form-control']);
                echo $this->Form->input('email', ['type' => 'email', 'class' => 'form-control']);
                echo $this->Form->input('password', ['type' => 'password', 'class' => 'form-control']);
                echo $this->Form->input('birth', [
                    'label' => 'Date of birth',
                    'minYear' => date('Y') - 70,
                    'maxYear' => date('Y') - 16,
                    'class' => 'form-control'
                ]);
                echo $this->Form->submit('Sign up', array('class' => 'btn-form'));
            ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>