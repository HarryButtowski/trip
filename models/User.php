<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use yii\web\Link;
use yii\web\Linkable;

/**
 * This is the model class for table "user".
 *
 * @property integer    $id
 * @property integer    $department_id
 * @property string     $surname
 * @property string     $name
 * @property string     $patronymic
 * @property string     $login
 * @property string     $password
 * @property string     $salt
 *
 * @property Trip[]     $trips
 * @property Department $department
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface, Linkable
{
    const SCENARIO_CREATE = 'create';

    private $_role = '';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @param string $login
     *
     * @return User|null
     */
    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id', 'surname', 'name', 'patronymic', 'login', 'role'], 'required'],
            [['password'], 'required', 'on' => static::SCENARIO_CREATE],
            [['login'], 'unique'],
            ['login', function ($attribute, $params, $validator) {
                if (!preg_match('/^[a-z0-9_-]{3,16}$/', $this->{$attribute})) {
                    $this->addError($attribute, 'Login must match the pattern: /^[a-z0-9_-]{3,16}$/');
                }
            }],
            [['password'], 'safe'],
            [['department_id'], 'integer'],
            [['surname', 'name', 'patronymic', 'login', 'password'], 'string', 'max' => 255],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function setAttributes($values, $safeOnly = true)
    {
        if (empty($values['password'])) {
            $values['password'] = $this->password;
        } else {
            $values['password'] = Yii::$app->getSecurity()->generatePasswordHash($values['password']);
        }

        $this->auth_key = \Yii::$app->security->generateRandomString();
        $this->access_token = \Yii::$app->security->generateRandomString();

        parent::setAttributes($values, $safeOnly);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'department_id' => 'Department ID',
            'surname'       => 'Surname',
            'name'          => 'Name',
            'patronymic'    => 'Patronymic',
            'login'         => 'Login',
            'password'      => 'Password',
            'role'          => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrips()
    {
        return $this->hasMany(Trip::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * @param string $password
     *
     * @return bool
     */
    public function validatePassword($password)
    {
        $user = static::findOne($this->id);

        return Yii::$app->getSecurity()->validatePassword($password, $user->password);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $result = parent::save($runValidation, $attributeNames);

        $this->setRoleByUser();

        return $result;
    }

    private function setRoleByUser()
    {
        Yii::$app->authManager->revokeAll($this->id);
        $userRole = Yii::$app->authManager->getRole($this->getRole());
        Yii::$app->authManager->assign($userRole, $this->id);
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->_role ?: (Yii::$app->authManager->getRolesByUser($this->id) ? key(Yii::$app->authManager->getRolesByUser($this->id)): '');
    }

    /**
     * @param string $value
     */
    public function setRole($value)
    {
        $this->_role = $value;
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        unset($fields['password'], $fields['auth_key'], $fields['access_token']);

        $fields['department'] = function($model) {
            return $model->department->name;
        };

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['department'];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
        ];
    }
}
