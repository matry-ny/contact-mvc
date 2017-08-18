<?php

namespace console\migrations;

use components\Model;

/**
 * Class m1503088137_add_comment_moderated_column
 * @package console\migrations;
 */
class m1503088137_add_comment_moderated_column extends Model
{
    public function up()
    {
        $this->addColumn('comments', 'is_moderated', 'int(1) DEFAULT 0 AFTER author');
    }
    
    public function down()
    {
        $this->dropColumn('comments', 'is_moderated');
    }
}