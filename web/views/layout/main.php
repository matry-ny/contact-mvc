<?php

use components\Registry;
use helpers\Bootstrap;
use helpers\Url;

/**
 * @var string $content
 */

/** @var \components\Session $session */
$session = Registry::get('session');

?>
<html>
<head>
    <title>Contact form</title>

    <link rel="stylesheet" href="<?= Bootstrap::getFileUrl('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= Bootstrap::getFileUrl('css/bootstrap-theme.min.css') ?>">

</head>
<body>
<div class="container">
    <br>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?= Url::prepare('/') ?>">Contact form</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?= Url::prepare('/') ?>">Home</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?= Url::prepare('/guest/log-out') ?>">Sign Out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <?php if ($session->hasFlash('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= $session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    <?php if ($session->hasFlash('error')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?= $content ?>

    <footer class="footer">
        <p>&copy; PHP Academy <?= date('Y') ?></p>
    </footer>

</div>

<script src="<?= Bootstrap::getFileUrl('js/bootstrap.min.js') ?>"></script>
</body>
</html>