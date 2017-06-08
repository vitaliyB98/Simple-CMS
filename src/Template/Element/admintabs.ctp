<?php if ($role === 3): ?>
<ul class="nav nav-tabs">
    <li>
        <?= $this->Html->link('Logs', ['controller' => 'Logs', 'action' => 'index']) ?>
    </li>
    <li>
        <?= $this->Html->link('Articles', ['controller' => 'Articles', 'action' => 'tableList']) ?>
    </li>
    <li>
        <?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']) ?>
    </li>
    <li>
        <?= $this->Html->link('Roles', ['controller' => 'Roles', 'action' => 'index']) ?>
    </li>
</ul>
<?php endif ?>
