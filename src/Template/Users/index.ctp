<?= $this->Html->link('Back', ['controller' => 'Admin', 'action' => 'index']) ?>
<h1>Users</h1>

<?= $this->Html->link('Add user', ['action' => 'add'], ['class' => 'btn btn-info']) ?>

<table>
    <tr>
        <th>
            ID
        </th>
        <th>
            Name
        </th>
        <th>
            Alias
        </th>
        <th>
            Email
        </th>
        <th>
            Role
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
            <?= $user->role ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?>
            <?= $this->Form->postLink(
                'Delete',
                    ['action' => 'delete', $user->id],
                    ['confirm' => 'Are you sure?']
                )
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
