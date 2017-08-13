<?php

use helpers\Url;

?>

<form class="form-signin" action="<?= Url::prepare('/guest/authorize') ?>" method="post">
    <h2 class="form-signin-heading">Please sign in</h2>

    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>

<p class="text-center">or <a href="<?= Url::prepare('/guest/register') ?>">create new account</a></p>