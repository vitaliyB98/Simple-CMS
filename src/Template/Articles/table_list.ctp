<h1><?= __('Articles') ?></h1>

<?= $this->element('/admintabs'); ?>

<?= $this->Html->link('Add post', ['action' => 'add'], ['class' => 'btn btn-info']) ?>
<table>
    <tr>

        <th>
            <?= $this->Paginator->sort('title') ?>
        </th>
        <th>
            <?= $this->Paginator->sort('created') ?>
        </th>
        <th>
            <?= $this->Paginator->sort('user_id') ?>
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
            <?php
                if (!empty($article->user->id)) {
                    echo $this->Html->link($article->user->name,
                        ['controller' => 'Users', 'action' => 'view', $article->user->id]);
                } else {
                    echo __('Author was deleted');
                }
            ?>
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
<?= $this->element('/paginator'); ?>
