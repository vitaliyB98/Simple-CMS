<h1>Users</h1>

<table>
    <tr>
        <th>
            id
        </th>
        <th>
            email
        </th>
    </tr>
    <?php foreach($users as $user): ?>
    <tr>
        <td>
            <?= $this->Html->link($user->id, ['action' => 'view', $user->id]) ?>
        </td>
        <td>
            <?= $user->email ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
