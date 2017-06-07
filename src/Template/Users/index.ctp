<h1><?= __('Users') ?></h1>
<?= $this->element('/admintabs'); ?>
<?= $this->Html->link('Add user', ['action' => 'add'], ['class' => 'btn btn-info']) ?>

<table>
    <tr>
        <th>
            <?= $this->Html->link('ID', [
                'action' => 'index',
                '?' => ['sort_by' => 'Users.id', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']
            ]) ?>
        </th>
        <th>
            <?= $this->Html->link('Name', [
                'action' => 'index',
                '?' => ['sort_by' => 'Users.name', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']
            ]) ?>
        </th>
        <th>
            <?= $this->Html->link('Alias', [
                'action' => 'index',
                '?' => ['sort_by' => 'Users.alias', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']
            ]) ?>
        </th>
        <th>
            <?= $this->Html->link('Email', [
                'action' => 'index',
                '?' => ['sort_by' => 'Users.email', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']
            ]) ?>
        </th>
        <th>
            <?= $this->Html->link('Role', [
                'action' => 'index',
                '?' => ['sort_by' => 'Users.role', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']
            ]) ?>
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
                    ['confirm' => 'Delete all user`s post?']
                )
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<ul class="pagination">
    <?= $this->Paginator->prev('« Previous') ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('Next »') ?>
</ul>
