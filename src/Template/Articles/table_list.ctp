<h1><?= __('Articles') ?></h1>

<?= $this->element('/admintabs'); ?>

<?= $this->Html->link('Add post', ['action' => 'add'], ['class' => 'btn btn-info']) ?>
<table>
    <tr>

        <th>
            <?= $this->Html->link('Title', ['action' => 'table-list','?' => ['sort_by' => 'Articles.title', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']]) ?>
        </th>
        <th>
            <?= $this->Html->link('Created', ['action' => 'table-list','?' => ['sort_by' => 'Articles.created', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']]) ?>
        </th>
        <th>
            <?= $this->Html->link('Author', ['action' => 'table-list', '?' => ['sort_by' => 'Users.name', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']]) ?>
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php foreach ($articles as $article): ?>
    <tr>
        <td>
            <?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?>
        </td>
        <td>
            <?= $article->created->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $article->user->name ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $article->id]) ?>
            <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $article->id],
                    ['confirm' => 'Are you sure?']
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
