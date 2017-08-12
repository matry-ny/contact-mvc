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

    <link rel="stylesheet" href="<?= Bootstrap::getFileUrl('css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= Bootstrap::getFileUrl('css/bootstrap-theme.css') ?>">

</head>
<body>
<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills float-right">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= Url::prepare('/') ?>">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </nav>
    </div>

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