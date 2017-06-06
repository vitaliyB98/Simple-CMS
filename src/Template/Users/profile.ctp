<h1>Profile</h1>
<fieldset>
    <legend>Information about me.</legend>
    <?= $this->Html->link('Edit', ['controller' => 'Users','action' => 'edit', $user->id], ['class' => 'btn btn-info']) ?>
    <h4>Name: <?= $user->name ?></h4>
    <h4>Alias: <?= $user->alias ?></h4>
    <h4>Email: <?= $user->email ?></h4>
    <h4>Birth day: <?= $user->birth ?></h4>
    <h4>Role: <?= $role ?></h4>
</fieldset>


<h1>My articles</h1>
<?= $this->Html->link('Add post', ['controller' => 'Articles' ,'action' => 'add'], ['class' => 'btn btn-info']) ?>
<table>
    <tr>
        <th>
            <?= $this->Html->link('Title', [
                'action' => 'profile',
                '?' => ['sort_by' => 'Articles.title', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']
            ]) ?>
        </th>
        <th>
            <?= $this->Html->link('Created', [
                'action' => 'profile',
                '?' => ['sort_by' => 'Articles.created', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']
            ]) ?>
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php foreach ($articles as $article): ?>
    <tr>
        <td>
            <?= $this->Html->link($article['title'], ['controller' => 'Articles', 'action' => 'view', $article['id']]) ?>
        </td>
        <td>
            <?= $article['created'] ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['controller' => 'Articles', 'action' => 'edit', $article['id']]) ?>
            <?= $this->Form->postLink(
            'Delete',
            ['controller' => 'Articles' ,'action' => 'delete', $article['id']],
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
