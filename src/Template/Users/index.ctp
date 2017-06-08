<h1><?= __('Users') ?></h1>
<?= $this->element('/admintabs'); ?>
<?= $this->element('/delete_modal'); ?>
<?= $this->Html->link('Add user', ['action' => 'add'], ['class' => 'btn-theme']) ?>

<table>
    <tr>
        <th>
            <?= $this->Paginator->sort('id') ?>
        </th>
        <th>
            <?= $this->Paginator->sort('name') ?>
        </th>
        <th>
            <?= $this->Paginator->sort('alias') ?>
        </th>
        <th>
            <?= $this->Paginator->sort('email') ?>
        </th>
        <th>
            <?= __('Role') ?>
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php foreach($users as $user): ?>
    <tr>
        <td>
            <?= $user->id ?>
        </td>
        <td>
            <?= $this->Html->link($user->name, ['action' => 'view', $user->id]) ?>
        </td>
        <td>
            <?= $user->alias ?>
        </td>
        <td>
            <?= $user->email ?>
        </td>
        <td>
            <?= $user->role->role_name ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?>
            <?= $this->Html->link('Delete', ['controller' => 'users'], ['data-remodal-target' => 'modal', 'id' => $user->id]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?= $this->element('/paginator'); ?>

<?= $this->Html->script('modal.js') ?>
