<h1>Posts</h1>
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
