<?= $this->Html->link('Back', ['controller' => 'Articles', 'action' => 'index']) ?>
<?php if ($role == '3'): ?>
<div class = "mini-toolbar text-right">
    <?= $this->Html->link('Edit', ['controller' => 'Articles', 'action' => 'edit', $article['id']]) ?>
</div>
<hr>
<?php endif ?>
<h3><?= $article['title'] ?></h3>
<small><?= $article['created'] ?> by <?= $this->Html->link($article['user']['name'], ['controller' => 'Users', 'action' => 'view', $article['user']['id']]) ?></small>

<?php if ($article['image'] !== NULL): ?>
<a class="colorbox" href="<?= $article['image']['img_name'] ?>">
    <?= $this->Html->image($article['image']['img_name'], ['class' => 'img img-responsive']) ?>
</a>
<?php endif ?>

<p>
    <?= $article['body'] ?>
</p>

