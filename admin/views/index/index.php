<?php

use helpers\Url;
use \models\User;

/**
 * @var \models\Comment[] $comments
 */

?>

<div class="row">
    <div class="col-lg-12">

        <h2>Not moderated comments</h2>

        <?php foreach ($comments as $comment) : ?>

            <div class="row">
                <div class="col-sm-1">#<?= $comment->id ?></div>
                <div class="col-sm-8">
                    <p>
                        <?= $comment->user_name ?>

                        <?php if ($comment->author) : ?>

                            <?php
                            /** @var User $user */
                            $user = (new User())->find($comment->author);
                            ?>
                            (<?= $user->name ?> [<?= $user->email ?>])

                        <?php endif; ?>
                    </p>
                    <p><?= $comment->comment ?></p>
                </div>
                <div class="col-sm-3">
                    <?= $comment->created_at ?>
                    <a href="<?= Url::prepare("/comments/moderate/id/{$comment->id}") ?>" class="btn btn-xs btn-success">Moderate</a>
                    <a href="<?= Url::prepare("/comments/delete/id/{$comment->id}") ?>" class="btn btn-xs btn-danger">Delete</a>
                </div>
            </div>
            <hr>

        <?php endforeach; ?>
    </div>
</div>
