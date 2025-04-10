<?php

use yii\db\Migration;

class m250407_203125_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('users', [
            'id' => $this->primaryKey()->comment('ID записи'),
            'nomination_id' => $this->integer()->notNull()->comment('ID номинации'),
            'last_name' => $this->string(100)->notNull()->comment('Фамилия'),
            'first_name' => $this->string(100)->notNull()->comment('Имя'),
            'middle_name' => $this->string(100)->comment('Отчество'),
            'group' => $this->string(50)->notNull()->comment('Группа'),
            'username' => $this->string(50)->notNull()->unique()->comment('Логин'),
            'password' => $this->string(255)->notNull()->comment('Пароль (хэш)'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата обновления'),
        ], $tableOptions);

        $this->addForeignKey(
            'fk-users-nomination_id',
            'users',
            'nomination_id',
            'nominations',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-users-nomination_id', 'users');
        $this->dropTable('users');
    }
}
