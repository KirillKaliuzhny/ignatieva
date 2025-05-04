<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id ID записи
 * @property int $nomination_id ID номинации
 * @property string $last_name Фамилия
 * @property string $first_name Имя
 * @property string|null $middle_name Отчество
 * @property string $group Группа
 * @property string $username Логин
 * @property string $password Пароль (хэш)
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 *
 * @property Nominations $nomination
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'last_name', 'first_name', 'group', 'nomination_id'], 'required', 'message' => 'Поле "{attribute}" обязательно для заполнения'],

            [['nomination_id'], 'integer', 'message' => 'Поле "{attribute}" должно быть целым числом'],

            [['last_name', 'first_name', 'middle_name'], 'string', 'max' => 100,
                'tooLong' => 'Максимальная длина {attribute} - {max} символов'],

            [['group', 'username'], 'string', 'max' => 50,
                'tooLong' => 'Максимальная длина {attribute} - {max} символов'],

            [['password'], 'string', 'max' => 255,
                'tooLong' => 'Максимальная длина пароля - {max} символов'],

            [['username'], 'unique', 'message' => 'Этот логин уже занят'],

            [['nomination_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Nomination::class,
                'targetAttribute' => ['nomination_id' => 'id'],
                'message' => 'Выбранная номинация не существует'],
            [['role'], 'string', 'max' => 20],
            [['role'], 'default', 'value' => self::ROLE_USER],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomination_id' => 'Номинация',
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'middle_name' => 'Отчество',
            'group' => 'Группа',
            'username' => 'Логин',
            'password' => 'Пароль',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Nomination]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNomination()
    {
        return $this->hasOne(Nomination::class, ['id' => 'nomination_id']);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['nomination_id', 'last_name', 'first_name', 'middle_name', 'group', 'username', 'password'];
        return $scenarios;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }
    public function getFiles()
    {
        return $this->hasMany(UserFile::class, ['user_id' => 'id'])->indexBy('file_type');
    }

    public function getUserName()
    {
        return $this->first_name . ' ' . $this->last_name . ' (' . $this->group . ')';
    }


}
