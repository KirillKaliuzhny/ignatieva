<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_files}}`.
 */
class m250408_220849_create_user_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_file', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->smallInteger()->notNull()->comment('1 - первый файл, 2 - второй файл'),
            'original_name' => $this->string(255)->notNull(),
            's3_key' => $this->string(255)->notNull(),
            'size' => $this->bigInteger()->notNull(),
            'mime_type' => $this->string(100)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_file-user_id',
            'user_file',
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
        $this->dropTable('user_file');
    }
}
