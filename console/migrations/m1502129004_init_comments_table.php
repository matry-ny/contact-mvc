<?php

namespace console\migrations;

use components\Model;

/**
 * Class m1502129004_init_comments_table
 * @package console\migrations;
 */
class m1502129004_init_comments_table extends Model
{
    const COMMENT_TABLE = 'comments';

    public function up()
    {
        $this->createTable(self::COMMENT_TABLE, [
            'id INT(11) NOT NULL AUTO_INCREMENT',
            'user_name VARCHAR(255) NOT NULL',
            'comment TEXT NOT NULL',
            'created_at DATETIME',
            'updated_at DATETIME',
            'PRIMARY KEY(`id`)'
        ]);
    }
    
    public function down()
    {
        $this->dropTable(self::COMMENT_TABLE);
    }
}