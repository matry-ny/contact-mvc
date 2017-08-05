<?php

use helpers\Url;

/**
 * @var \models\Comment[] $records
 */

?>

<form action="<?= Url::prepare('/comments/create') ?>" method="post">
    <input name="user_name" type="text" placeholder="Your name"><br>
    <textarea name="comment" placeholder="You comment"></textarea><br>
    <input type="submit" value="Submit">
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
        <p><a href="<?= Url::prepare("/comments/view?id={$record->id}") ?>">Edit</a></p>
    </div>
    <hr>
<?php endforeach; ?>
