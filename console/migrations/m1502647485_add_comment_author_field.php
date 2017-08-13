<?php

namespace console\migrations;

use components\Model;

/**
 * Class m1502647485_add_comment_author_field
 * @package console\migrations;
 */
class m1502647485_add_comment_author_field extends Model
{
    const AUTHOR_FIELD = 'author';
    const AUTHOR_KEY = 'fk_comments_author_users_id';

    public function up()
    {
        $this->addColumn('comments', self::AUTHOR_FIELD, 'INT(11) AFTER comment');
        $this->addForeignKey('comments', self::AUTHOR_KEY, self::AUTHOR_FIELD, 'users', 'id');
    }
    
    public function down()
    {
        $this->dropForeignKey('comments', self::AUTHOR_KEY);
        $this->dropColumn('comments', self::AUTHOR_FIELD);
    }
}