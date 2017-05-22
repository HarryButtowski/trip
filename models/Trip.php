<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "trip".
 *
 * @property integer      $id
 * @property integer      $user_id
 * @property integer      $organization_id
 * @property integer      $date_start
 * @property integer      $date_end
 * @property string       $expenses
 *
 * @property Organization $organization
 * @property User         $user
 */
class Trip extends \yii\db\ActiveRecord
{
    const SCENARIO_CLOSURE = 'closure';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'organization_id', 'date_start', 'date_end'], 'required', 'on' => static::SCENARIO_DEFAULT],
            [['user_id', 'organization_id', 'date_start', 'date_end'], 'integer', 'on' => static::SCENARIO_DEFAULT],
            [['date_start', 'date_end'], 'validateDate', 'on' => static::SCENARIO_DEFAULT],
            [['expenses'], 'string', 'on' => static::SCENARIO_CLOSURE],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function validateDate($attribute, $params, $validator)
    {
        if (static::find()->where(['<=', 'date_start', $this->{$attribute}])->andWhere(['>=', 'date_end', $this->{$attribute}])->all()) {
            $this->addError($attribute, 'Date is not valid');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'user_id'         => 'User ID',
            'organization_id' => 'Organization ID',
            'date_start'      => 'Date Start',
            'date_end'        => 'Date End',
            'expenses'        => 'Expenses',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'organization' => function ($model) {
                return $model->organization->name;
            },
            'user'         => function ($model) {
                return $model->user->name;
            },
            'date_start'   => function ($model) {
                return date('Y - m - d', $model->date_start);
            },
            'date_end'     => function ($model) {
                return date('Y - m - d', $model->date_end);
            },
            'expenses'     => function ($model) {
                return Json::decode($model->expenses, true);
            },
        ]);
    }

    /**
     * @inheritdoc
     */
    public function setAttributes($values, $safeOnly = true)
    {
        parent::setAttributes($values, $safeOnly);

        $this->date_start = strtotime($this->date_start);
        $this->date_end   = strtotime($this->date_end);

        if (isset($values['expenses'])) {
            $this->expenses = Json::encode($values['expenses']);
        }
    }

    /**
     * @return array
     */
    public function getExpensesItems()
    {
        return Json::decode($this->expenses, true) ?: [];
    }
}
