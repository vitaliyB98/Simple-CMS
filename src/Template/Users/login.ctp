<?= $this->Flash->render() ?>
<div class = "users form form-login">
    <?= $this->Form->create() ?>
    <fieldset>
        <h2>Login</h2>
        <div class = "form-group">
            <?= $this->Form->input('alias', ['type' => 'text', 'class' => 'form-control']) ?>
            <?= $this->Form->input('password', ['type' => 'password', 'class' => 'form-control']) ?>
        </div>
        <?= $this->Form->submit('Login', array('class' => 'btn-form')) ?>
        <?= $this->Html->link('Sign up', ['controller' => 'users', 'action' => 'signup'], ['class' => 'text-center']) ?>
    </fieldset>
    <?= $this->Form->end() ?>

 </div>
