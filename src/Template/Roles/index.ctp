<h1>Roles</h1>
<ul class="nav nav-tabs">
    <li>
        <?= $this->Html->link('Back', ['controller' => 'Admin', 'action' => 'index']) ?>
    </li>
    <li>
        <?= $this->Html->link('Posts', ['controller' => 'Articles', 'action' => 'tableList']) ?>
    </li>
    <li>
        <?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']) ?>
    </li>
    <li>
        <?= $this->Html->link('Roles', ['controller' => 'Roles', 'action' => 'index']) ?>
    </li>
</ul>
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
