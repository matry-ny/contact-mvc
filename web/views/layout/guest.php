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
    <title>Contact form sign in</title>

    <link rel="stylesheet" href="<?= Bootstrap::getFileUrl('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= Bootstrap::getFileUrl('css/bootstrap-theme.min.css') ?>">
    <link rel="stylesheet" href="<?= Url::prepare('/web/public/css/sign-in.css') ?>">

</head>
<body>
<div class="container">

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

</div>

<script src="<?= Bootstrap::getFileUrl('js/bootstrap.min.js') ?>"></script>
</body>
</html>