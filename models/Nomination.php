<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nominations".
 *
 * @property int $id
 * @property string $title Название номинации
 * @property string $description Описание номинации
 * @property string|null $format Формат номинации
 * @property string|null $requirements Требования к участникам
 * @property int $active
 * @property int $max_users
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 *
 * @property Users[] $users
 */
class Nomination extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nominations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['format', 'requirements'], 'default', 'value' => null],
            [['active'], 'default', 'value' => 1],
            [['max_users'], 'default', 'value' => 2],
            [['title', 'description', 'created_at', 'updated_at'], 'required'],
            [['description', 'format', 'requirements'], 'string'],
            [['active', 'max_users', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'format' => 'Format',
            'requirements' => 'Requirements',
            'active' => 'Active',
            'max_users' => 'Max Users',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['nomination_id' => 'id'])->where(['role' => User::ROLE_USER]);
    }
}
