<?php

use components\Registry;
use admin\helpers\Theme;
use helpers\Url;

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

<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= Url::prepare('/') ?>">Admin</a>
        </div>

        <ul class="nav navbar-right navbar-top-links">
            <li><a href="<?= Url::prepare('/guest/log-out') ?>"><i class="fa fa-sign-out"></i> Sign out</a></li>
        </ul>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="<?= Url::prepare('/') ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">

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
    </div>

</div>

<script src="<?= Theme::getFileUrl('js/jquery.min.js') ?>"></script>
<script src="<?= Theme::getFileUrl('js/bootstrap.min.js') ?>"></script>
<script src="<?= Theme::getFileUrl('js/metisMenu.min.js') ?>"></script>
<script src="<?= Theme::getFileUrl('js/startmin.js') ?>"></script>

</body>
</html>

