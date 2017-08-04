<?php

use helpers\Url;

?>

<form action="<?= Url::prepare('/comments/create') ?>" method="post">
    <input name="user_name" type="text" placeholder="Your name"><br>
    <textarea name="comment" placeholder="You comment"></textarea><br>
    <input type="submit" value="Submit">
</form>