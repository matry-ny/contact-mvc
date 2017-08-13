<?php

use helpers\Url;

?>

<form class="form-signin" action="<?= Url::prepare('/guest/create-account') ?>" method="post">
    <h2 class="form-signin-heading">Enter account data</h2>

    <div class="form-group">
        <label for="inputName" class="sr-only">Name</label>
        <input type="text" name="name" id="inputNme" class="form-control" placeholder="Your name" required autofocus>
    </div>
    <div class="form-group">
        <label for="inputEmail" class="sr-only">Email address (login)</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required>
    </div>
    <div class="form-group">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    </div>
    <div class="form-group">
        <label for="inputRepeatPassword" class="sr-only">Repeat password</label>
        <input type="password" name="repeat_password" id="inputRepeatPassword" class="form-control" placeholder="Repeat password" required>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Create account</button>
</form>

<p class="text-center">or <a href="<?= Url::prepare('/guest/login') ?>">sign in</a></p>