<?= $this->Html->link('Back', ['controller' => 'Admin', 'action' => 'index']) ?>
<h1>Roles</h1>
<?= $this->Html->link('Add role', ['action' => 'add']) ?>
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
