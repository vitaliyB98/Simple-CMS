<?= $this->Html->link('Back', ['controller' => 'Articles', 'action' => 'index']) ?>

<h3><?= $article->title ?></h3>
<small><?= $article->created ?></small>
<p>
    <?= $article->body ?>
</p>