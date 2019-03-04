<?php

namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $password write-only password
 */
class Users extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%users}}';
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->created_at = date("Y-m-d H:i:s");
            $this->updated_at = date("Y-m-d H:i:s");
        } else {
            $this->updated_at = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['username', 'password', 'first_name', 'last_name', 'email', 'auth_key', 'status', 'amember'], 'required'],
            [['status', 'amember'], 'integer'],
            [['type'], 'string'],
            [['type', 'created_at', 'updated_at', 'last_visit'], 'safe'],
            [['username', 'auth_key'], 'string', 'max' => 128],
            [['password', 'password_reset_token', 'email'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['email'], 'email'],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'type' => 'Type',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'last_visit' => 'Last Visited',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE, 'type' => 'general']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE, 'type' => 'general']);
    }

    public static function findByUsernameOrEmail($username) {
        $user = static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE, 'type' => 'general']);
        if (!$user) {
            return static::findOne(['email' => $username, 'status' => self::STATUS_ACTIVE, 'type' => 'general']);
        }
        return $user;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function sendEmail($supportEmail, $adminEmail, $body, $name, $u_email,$u_body,$u_name) {
        Yii::$app->mailer->htmlLayout = "layouts/html";
		$adminSuccess = Yii::$app
                ->mailer
                ->compose(
                        ['html' => 'newOrder-html', 'text' => 'newOrder-text'], [
                    'email' => $adminEmail,
                    'body' => $body,
                    'name' => $name,
                    'supportEmail' => $supportEmail,
                        ]
                )
                ->setFrom([$supportEmail => '8thwonderpromos'])
                ->setTo($supportEmail)
                ->setSubject('New Order Placed')
                ->send();
        $userSuccess = Yii::$app
                ->mailer
                ->compose(
                        ['html' => 'newOrder-html', 'text' => 'newOrder-text'], [
                    'email' => $u_email,
                    'body' => $u_body,
                    'name' => $u_name,
                    'supportEmail' => $supportEmail,
                        ]
                )
                ->setFrom([$supportEmail => '8thwonderpromos'])
                ->setTo($this->email)
                ->setSubject('8thwonderpromos: Order Details')
                ->send();
        return $userSuccess && $adminSuccess;
    }

}
