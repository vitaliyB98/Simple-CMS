<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="dropdown">
    <a class="dropdown-toggle"  data-toggle="dropdown">Actions
        <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><?= $this->Form->postLink(__('Delete Log'), ['action' => 'delete', $log->id], ['confirm' => __('Are you sure you want to delete # {0}?', $log->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Logs'), ['action' => 'index']) ?> </li>
    </ul>
</div>

<div class="logs view large-9 medium-8 columns content">
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($log->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($log->created) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Body Log') ?></h4>
        <?= $this->Text->autoParagraph(h($log->body_log)); ?>
    </div>
</div>
