<?= $this->Html->link('Back', ['controller' => 'Admin', 'action' => 'index']) ?>
<h1>Posts</h1>
<?= $this->Html->link('Add post', ['action' => 'add']) ?>
<table>
    <tr>
        <th>
            Title
        </th>
        <th>
            Created
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
