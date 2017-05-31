<!-- FILE: src/Template/Articles/index.php -->

<h1>Welcome</h1>

    <div>
        <?php foreach ($articles as $article): ?>
            <article>
                <h3><?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?></h3>
                <small><?= $article->created->format(DATE_RFC850) ?></small>
                <p>
                    <?= $article->body ?>
                </p>
            </article>
        <?php endforeach; ?>
    </div>

<ul class="pagination">
    <?= $this->Paginator->prev('« Previous') ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('Next »') ?>
</ul>

