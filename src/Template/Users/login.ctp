<div class = "users form">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Please enter your alias and password')?></legend>
            <?= $this->Form->input('alias', array('type' => 'text')) ?>
            <?= $this->Form->input('password', array('type' => 'password')) ?>
            <?= $this->Form->submit('Login', array('class' => 'btn btn-primary')) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>