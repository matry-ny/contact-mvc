<?php

use helpers\Url;

/**
 * @var \models\Comment $comment
 */

?>

<form action="<?= Url::prepare('/comments/update/id/' . $comment->id) ?>" method="post">

    <div class="form-group">
        <label for="nameInput">Your name</label>
        <input type="text"
               name="user_name"
               class="form-control"
               id="nameInput"
               placeholder="Enter your name"
               value="<?= $comment->user_name ?>">
    </div>

    <div class="form-group">
        <label for="commentTextArea">Your comment</label>
        <textarea name="comment"
                  id="commentTextArea"
                  class="form-control"
                  placeholder="Enter your comment"><?= $comment->comment ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-success" value="Submit">
        <a href="<?= Url::prepare("/comments/delete/id/{$comment->id}") ?>" class="btn btn-danger">Delete</a>
    </div>
</form>
