<h1><?= __('Users') ?></h1>
<?= $this->element('/admintabs'); ?>
<?= $this->Html->link('Add user', ['action' => 'add'], ['class' => 'btn btn-info']) ?>

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
            <?= $this->Paginator->sort('role') ?>
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
