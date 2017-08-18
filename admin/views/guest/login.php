<?php

use helpers\Url;

?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Please Sign In</h3>
            </div>
            <div class="panel-body">
                <form role="form" action="<?= Url::prepare('/guest/authorize') ?>" method="post">
                    <fieldset>

                        <div class="form-group">
                            <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                        </div>

                        <div class="form-group">
                            <input class="form-control" placeholder="Password" name="password" type="password" value="">
                        </div>

                        <input type="submit" value="Login" class="btn btn-lg btn-success btn-block">

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>