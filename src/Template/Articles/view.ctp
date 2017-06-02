<?= $this->Html->link('Back', ['controller' => 'Articles', 'action' => 'index']) ?>

<h3><?= $article['title'] ?></h3>
<small><?= $article['created'] ?> by <b><?= $article['user']['name'] ?></b></small>
<p>
    <?= $article['body'] ?>
</p>

<?php if ($article['image'] !== NULL): ?>
<a class="colorbox" href="<?= $article['image']['img_name'] ?>">
<?= $this->Html->image($article['image']['img_name'], ['class' => 'img img-responsive']) ?>
</a>
<?php endif ?>