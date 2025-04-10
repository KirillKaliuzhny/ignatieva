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
        return 'user_file';
    }

    public function rules()
    {
        return [
            [['user_id', 'type', 'original_name', 's3_key', 'size', 'mime_type'], 'required'],
            [['user_id', 'type', 'size', 'created_at', 'updated_at'], 'integer'],
            [['original_name', 's3_key'], 'string', 'max' => 255],
            [['mime_type'], 'string', 'max' => 100],
            ['type', 'in', 'range' => [self::TYPE_IMAGE, self::TYPE_CDR]],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}