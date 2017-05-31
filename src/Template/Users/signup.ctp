<div class = "users form">
    <?= $this->Form->create($user) ?>
        <fieldset>
            <legend><?= __('Sing Up') ?></legend>
            <?php
                echo $this->Form->input('name', ['type' => 'text']);
                echo $this->Form->input('alias', ['type' => 'text']);
                echo $this->Form->input('email', ['type' => 'email']);
                echo $this->Form->input('password', ['type' => 'password']);
                echo $this->Form->submit('Sign up', array('class' => 'btn btn-primary'));
            ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>