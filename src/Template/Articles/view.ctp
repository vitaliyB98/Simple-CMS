<?= $this->Html->link('Back', ['controller' => 'Articles', 'action' => 'index']) ?>
<?php if ($role == '3'): ?>
<div class = "mini-toolbar text-right">
    <?= $this->Html->link('Edit', ['controller' => 'Articles', 'action' => 'edit', $article['id']]) ?>
    <?= $this->Form->postLink(
        'Delete',
            ['action' => 'delete', $article['id']],
            ['confirm' => 'Are you sure delete?']
        )
    ?>
</div>
<hr>
<?php endif ?>
<h3><?= $article['title'] ?></h3>
<small><?= $article['created'] ?> by <b><?= $article['user']['name'] ?></b></small>

<?php if ($article['image'] !== NULL): ?>
<a class="colorbox" href="<?= $article['image']['img_name'] ?>">
    <?= $this->Html->image($article['image']['img_name'], ['class' => 'img img-responsive']) ?>
</a>
<?php endif ?>

<p>
    <?= $article['body'] ?>
</p>

