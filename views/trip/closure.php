<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Trip */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="trip-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?php
    $idExpenses = 0;

    if ($model->expensesItems) {
        foreach ($model->expensesItems as $item) {
            ?>
            <div class="form-group">
                <?= Html::label('Name') ?>
                <?= Html::input(
                    'text',
                    Html::getInputName($model, "expenses[$idExpenses][name]"),
                    isset($item['name']) ? $item['name'] : ''
                ) ?>
                <?= Html::label('Planned expenses') ?>
                <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][planed]"), isset($item['planed']) ? $item['planed'] : '') ?>
                <?= Html::label('Actual expenses') ?>
                <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][actual]"), isset($item['actual']) ? $item['actual'] : '') ?>
            </div>
            <?php
            $idExpenses++;
        }
    } else {
        ?>
        <div class="form-group">
            <?= Html::label('Name') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][name]"), '') ?>
            <?= Html::label('Planned expenses') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][planed]"), '') ?>
            <?= Html::label('Actual expenses') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][actual]"), '') ?>
        </div>
        <?php $idExpenses++; ?>
        <div class="form-group">
            <?= Html::label('Name') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][name]"), '') ?>
            <?= Html::label('Planned expenses') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][planed]"), '') ?>
            <?= Html::label('Actual expenses') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][actual]"), '') ?>
        </div>
        <?php $idExpenses++; ?>
        <div class="form-group">
            <?= Html::label('Name') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][name]"), '') ?>
            <?= Html::label('Planned expenses') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][planed]"), '') ?>
            <?= Html::label('Actual expenses') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][actual]"), '') ?>
        </div>
        <?php $idExpenses++; ?>
        <div class="form-group">
            <?= Html::label('Name') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][name]"), '') ?>
            <?= Html::label('Planned expenses') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][planed]"), '') ?>
            <?= Html::label('Actual expenses') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][actual]"), '') ?>
        </div>
        <?php $idExpenses++; ?>
        <div class="form-group">
            <?= Html::label('Name') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][name]"), '') ?>
            <?= Html::label('Planned expenses') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][planed]"), '') ?>
            <?= Html::label('Actual expenses') ?>
            <?= Html::input('text', Html::getInputName($model, "expenses[$idExpenses][actual]"), '') ?>
        </div>
        <?php
    } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>