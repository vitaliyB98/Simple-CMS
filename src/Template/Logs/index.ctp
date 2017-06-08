<?php
/**
  * @var \App\View\AppView $this
  */
?>

<h1><?= __('Logs') ?></h1>
<?= $this->element('/admintabs'); ?>

<?= $this->Form->postLink(__('Delete all ' . $count . ' logs'),
    ['action' => 'deleteAll'],
    ['confirm' => __('Are you sure you want to delete all logs?'), 'class' => 'btn-theme'])
?>


<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('body_log', 'About log') ?></th>
            <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logs as $log): ?>
        <tr>
            <td><?= h($log->body_log) ?></td>
            <td><?= empty($log->user->id) ? 'guest' : h($log->user->name) ?></td>
            <td><?= h($log->created) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $log->id]) ?>
                <?= $this->Form->postLink(__('Delete'),
                    ['action' => 'delete', $log->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $log->id)])
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->element('/paginator'); ?>

