<?php

use yii\db\Migration;

class m250407_195859_nominations extends Migration
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
        $this->createTable('nominations', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название номинации'),
            'description' => $this->text()->notNull()->comment('Описание номинации'),
            'format' => $this->text()->comment('Формат номинации'),
            'requirements' => $this->text()->comment('Требования к участникам'),
            'active' => $this->boolean()->notNull()->defaultValue(true),
            'max_users' => $this->integer()->notNull()->defaultValue(2),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата обновления'),
        ], $tableOptions);

        $this->createIndex(
            'idx-nominations-title',
            'nominations',
            'title'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('nominations');
    }

}
