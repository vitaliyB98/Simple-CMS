<!-- FILE: src/Template/Articles/index.php -->
<?php
    use App\Controller\AppController;
?>
<h1>Welcome</h1>

    <div>
        <?php foreach ($articles as $article): ?>
            <article>
                <h3><?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?></h3>
                <small><?= $article->created->format(DATE_RFC850) ?> by <b><?= $article->user->name?></b></small>
                <?php if ($article['image'] !== NULL): ?>
                <?= $this->Html->image($article->image->img_name, ['class' => 'img img-preview']) ?>
                <?php endif ?>
                <p>
                    <?= AppController::summary($article->body, 100) ?>
                </p>
                <?= $this->Html->link('Read more', ['action' => 'view', $article->id]) ?>
            </article>
        <?php endforeach; ?>
    </div>

<ul class="pagination">
    <?= $this->Paginator->prev('« Previous') ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('Next »') ?>
</ul>
