<?php
/**
  * @var \App\View\AppView $this
  */
?>

<h1><?= __('Logs') ?></h1>
<?= $this->element('/admintabs'); ?>

<?= $this->Form->postLink(__('Delete all logs'),
    ['action' => 'deleteAll'],
    ['confirm' => __('Are you sure you want to delete all logs?'), 'class' => 'btn btn-warning'])
?>

<div class="logs index large-9 medium-8 columns content">

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('body_log') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= $this->Number->format($log->id) ?></td>
                <td><?= h($log->body_log) ?></td>
                <td><?= h($log->user_id) ?></td>
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
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
    </div>
</div>
