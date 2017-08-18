<?php

use components\Registry;
use helpers\Bootstrap;
use helpers\Url;

/**
 * @var string $content
 */

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

    <?php if (Registry::get('session')->hasFlash('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= Registry::get('session')->getFlash('success') ?>
        </div>
    <?php endif; ?>
    <?php if (Registry::get('session')->hasFlash('error')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= Registry::get('session')->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?= $content ?>

</div>

<script src="<?= Bootstrap::getFileUrl('js/bootstrap.min.js') ?>"></script>
</body>
</html>