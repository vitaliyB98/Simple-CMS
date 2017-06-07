<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>

    <!-- Jquery -->
    <?= $this->Html->script('/bower_components/jquery/dist/jquery.js') ?>

    <!-- Bootstrap -->
    <?= $this->Html->css('/vendor/bootstrap/css/bootstrap.min.css') ?>
    <?= $this->Html->css('/vendor/bootstrap/css/bootstrap-theme.css') ?>
    <?= $this->Html->script('/vendor/bootstrap/js/bootstrap.min.js') ?>

    <?= $this->Html->css('main.css') ?>

    <!-- Color box -->
    <?= $this->Html->css('/bower_components/jquery-colorbox/example5/colorbox.css') ?>
    <?= $this->Html->script('/bower_components/jquery-colorbox/jquery.colorbox.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->script('main.js') ?>
    <?= $this->CKEditor->loadJs(); ?>
</head>
<body>
    <nav class="navbar navbar-them" data-topbar role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/" class="navbar-brand">Mini CMS</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href = "/">Home</a></li>
                    <?php if ($role == '3'): ?>
                    <li><a href = "/admin">Admin</a></li>
                    <?php endif; ?>
                    <?php if ($role): ?>
                    <li><a href = "/users/profile">My profile</a></a></li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if ($role): ?>
                    <li><a href = "/users/logout">Exit as <b><?= $user_alias ?></b></a></li>
                    <?php else: ?>
                    <li><a href = "/users/signup"><span class="glyphicon glyphicon-user"></span> Sign up</a></li>
                    <li><a href = "/users/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </nav>
    <?= $this->Flash->render() ?>

    <div class="container main-container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </footer>
</body>
</html>
