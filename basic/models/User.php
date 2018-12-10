<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $user_id;
    public $user_login;
    public $user_hash;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];
    public static function tableName(){
        return "users";
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
            $user = \Yii::$app->db->createCommand("SELECT * FROM users WHERE user_id = {$id}")->queryOne();
            return new static($user);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = \Yii::$app->db->createCommand("SELECT * FROM users WHERE user_hash = '{$token}'")->queryOne();
        return new static($user);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = \Yii::$app->db->createCommand("SELECT * FROM users WHERE user_login = '{$username}'")->queryOne();
        return new static($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->user_hash;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->user_hash === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->user_hash === md5($this->user_login . $password);
    }
}
