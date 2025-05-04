<?php

use yii\db\Migration;

class m250504_080354_user_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_files', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'file_url' => $this->string()->notNull(),
            'file_type' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_files-user_id',
            'user_files',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_files-user_id', 'user_files');
        $this->dropTable('user_files');
        return true;
    }

}
