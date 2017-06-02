<?= $this->Flash->render() ?>
<div class = "users form form-login">
        <?= $this->Form->create() ?>
        <fieldset>
            <h2>Login</h2>
            <?= $this->Form->input('alias', array('type' => 'text')) ?>
            <?= $this->Form->input('password', array('type' => 'password')) ?>
            <?= $this->Form->submit('Login', array('class' => 'btn-form')) ?>
        </fieldset>
        <?= $this->Form->end() ?>
 </div>
