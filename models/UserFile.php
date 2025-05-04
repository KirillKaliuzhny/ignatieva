<?php

// models/UserFile.php
namespace app\models;

use yii\db\ActiveRecord;

class UserFile extends ActiveRecord
{
    const TYPE_IMAGE = 1;
    const TYPE_CDR = 2;

    public static function tableName()
    {
        return 'user_files';
    }

    public function rules()
    {
        return [
            [['user_id', 'file_type'], 'required'],
            [['user_id', 'file_type','created_at', 'updated_at'], 'integer'],
            [['file_url'], 'string'],
            ['file_type', 'in', 'range' => [self::TYPE_IMAGE, self::TYPE_CDR]],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}