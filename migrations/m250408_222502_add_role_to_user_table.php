<?php

use yii\db\Migration;

class m250408_222502_add_role_to_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('users', 'role', $this->string(20)->notNull()->defaultValue('user'));
        $this->createIndex('idx-user-role', 'users', 'role');
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'role');
    }
}
