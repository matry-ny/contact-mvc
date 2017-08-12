<?php

use helpers\Url;

/**
 * @var \models\Comment[] $records
 */

?>

<form action="<?= Url::prepare('/comments/create') ?>" method="post">

    <div class="form-group">
        <label for="nameInput">Your name</label>
        <input type="text" name="user_name" class="form-control" id="nameInput" placeholder="Enter your name">
    </div>

    <div class="form-group">
        <label for="commentTextArea">Your comment</label>
        <textarea name="comment" id="commentTextArea" class="form-control" placeholder="Enter your comment"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-success" value="Submit">
    </div>
</form>

<hr>

<?php foreach ($records as $record) : ?>
    <div class="comment-record">
        <p>
            Created at: <?= $record->created_at ?><br>
            Updated at: <?= $record->updated_at ?><br>
            By: <b><?= $record->user_name ?></b>
        </p>
        <p><i><?= nl2br($record->comment) ?></i></p>
        <p>
            <a href="<?= Url::prepare("/comments/view/id/{$record->id}") ?>" class="btn btn-xs btn-info">Edit</a>
            <a href="<?= Url::prepare("/comments/delete/id/{$record->id}") ?>" class="btn btn-xs btn-danger">Delete</a>
        </p>
    </div>
    <hr>
<?php endforeach; ?>
