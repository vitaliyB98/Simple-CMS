<!-- FILE: src/Template/Articles/index.php -->

<h1>Всі записи</h1>

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