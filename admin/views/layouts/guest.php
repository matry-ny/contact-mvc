<?php

use components\Registry;
use admin\helpers\Theme;

/**
 * @var string $content
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <link href="<?= Theme::getFileUrl('css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= Theme::getFileUrl('css/metisMenu.min.css') ?>" rel="stylesheet">
    <link href="<?= Theme::getFileUrl('css/startmin.css') ?>" rel="stylesheet">
    <link href="<?= Theme::getFileUrl('css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
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

<script src="<?= Theme::getFileUrl('js/jquery.min.js') ?>"></script>
<script src="<?= Theme::getFileUrl('js/bootstrap.min.js') ?>"></script>
<script src="<?= Theme::getFileUrl('js/metisMenu.min.js') ?>"></script>
<script src="<?= Theme::getFileUrl('js/startmin.js') ?>"></script>

</body>
</html>

