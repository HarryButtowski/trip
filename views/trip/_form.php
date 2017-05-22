<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Trip */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trip-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'user_id')->dropDownList($this->context->getItemsForUserField())->label('User') ?>

    <?= $form->field($model, 'organization_id')->dropDownList($this->context->getItemsForOrganizationField())->label('Organization') ?>

    <?php $form->field($model, 'date_start')->textInput() ?>

    <?php
    echo DatePicker::widget([
        'model'     => $model,
        'attribute' => 'date_start',
        'dateFormat' => 'yyyy-MM-dd',
    ]);
    ?>

    <?php
    echo DatePicker::widget([
        'model'     => $model,
        'attribute' => 'date_end',
        'dateFormat' => 'yyyy-MM-dd',
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
