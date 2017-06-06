<!-- FILE: src/Template/Articles/index.php -->
<?php
    use App\Controller\AppController;
?>
<h1>Welcome</h1>

    <div>
        <div class="dropdown">
            <a class="dropdown-toggle"  data-toggle="dropdown">Sort by
                <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li>
                    <?= $this->Html->link('Created', [
                        'action' => 'index',
                        '?' => ['sort_by' => 'Articles.created', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']]) ?>
                </li>
                <li>
                    <?= $this->Html->link('Title', [
                        'action' => 'index',
                        '?' => ['sort_by' => 'Articles.title', 'type_sort' => isset($type_sort) ? $type_sort : 'ASC']]) ?>
                </li>
            </ul>
        </div>

        <?php foreach ($articles as $article): ?>
            <article>
                <h3><?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?></h3>
                <small>
                    <?= $article->created->format(DATE_RFC850) ?> by
                    <?= $this->Html->link($article->user->name, ['controller' => 'Users', 'action' => 'view', $article->user->id]) ?>
                </small>
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
