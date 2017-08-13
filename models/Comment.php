<?php

namespace models;

use components\Model;

/**
 * Class Comment
 * @package models
 *
 * @property int $id
 * @property string $user_name
 * @property string $comment
 * @property int $author
 * @property string $created_at
 * @property string $updated_at
 */
class Comment extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * @var array
     */
    protected $attributes = [
        'id' => null,
        'user_name' => null,
        'comment' => null,
        'author' => null,
        'created_at' => null,
        'updated_at' => null
    ];
}
