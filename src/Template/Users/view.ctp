<h2><?= $user->name ?></h2>
<h4>Registered: <?= $user->created ?></h4>
<a class = "btn btn-info" data-toggle="collapse" data-target="#demo">Show email</a>

<div id="demo" class="collapse">
    <h4><?= $user->email ?></h4>
</div>

