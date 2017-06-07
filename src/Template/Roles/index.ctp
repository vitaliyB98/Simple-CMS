<h1><?= __('Roles') ?></h1>
<?= $this->element('/admintabs'); ?>
<?= $this->Html->link('Add role', ['action' => 'add'], ['class' => 'btn btn-info']) ?>
<table>
    <tr>
        <th>
            ID
        </th>
        <th>
            Role name
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php foreach($roles as $role): ?>
    <tr>
        <td>
            <?= $role->id ?>
        </td>
        <td>
            <?= $role->role_name ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $role->id]) ?>
            <?= $this->Form->postLink(
                'Delete',
                    ['action' => 'delete', $role->id],
                    ['confirm' => 'Are you sure?']
                )
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
