<h1>Admin</h1>

<ul class="nav nav-tabs">
    <li>
        <?= $this->Html->link('Back', ['controller' => 'Admin', 'action' => 'index']) ?>
    </li>
    <li>
        <?= $this->Html->link('Posts', ['controller' => 'Articles', 'action' => 'tableList']) ?>
    </li>
    <li>
        <?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']) ?>
    </li>
    <li>
        <?= $this->Html->link('Roles', ['controller' => 'Roles', 'action' => 'index']) ?>
    </li>
</ul>