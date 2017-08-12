<?php

namespace console\migrations;

use components\Model;

/**
 * Class m1502534894_init_users_table
 * @package console\migrations;
 */
class m1502534894_init_users_table extends Model
{
    const USERS_TABLE = 'users';

    public function up()
    {
        $this->createTable(self::USERS_TABLE, [
            'id INT(11) NOT NULL AUTO_INCREMENT',
            'name VARCHAR(255) NOT NULL',
            'email VARCHAR(255) NOT NULL',
            'password VARCHAR(32) NOT NULL',
            'auth_token VARCHAR(32) NOT NULL',
            'is_admin INT(1)',
            'created_at DATETIME',
            'updated_at DATETIME',
            'PRIMARY KEY(`id`)'
        ]);
    }
    
    public function down()
    {
        $this->dropTable(self::USERS_TABLE);
    }
}