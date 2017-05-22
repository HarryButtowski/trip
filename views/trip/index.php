<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TripSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Trips';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Trip', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $roles = ArrayHelper::map(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()), 'type', 'name');

    switch (true) {
        case in_array('user', $roles):
            $columns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label'  => 'id',
                    'format' => 'html',
                    'value'  => function ($model) {
                        return Html::a($model->id, ["trip/closure", "id" => $model->user_id]);
                    },
                ],
                [
                    'label'  => 'user_id',
                    'format' => 'html',
                    'value'  => function ($model) {
                        return Html::a($model->user->name, ["trip/closure", "id" => $model->user_id]);
                    },
                ],
                [
                    'label'  => 'organization',
                    'format' => 'html',
                    'value'  => function ($model) {
                        return Html::a($model->organization->name, ["trip/closure", "id" => $model->user_id]);
                    },
                ],
                'date_start:date',
                'date_end:date',
                // 'expenses',
            ];

            break;
        default:
            $columns = [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'user.name',
                'organization.name',
                'date_start:date',
                'date_end:date',
                [
                    'label' => 'expenses',
                    'value' => function ($model) {
                        $sum = 0;

                        foreach ($model->expensesItems as $item) {
                            $sum = bcadd(
                                $sum,
                                isset($item['actual']) ? $item['actual'] : 0,
                                3
                            );
                        }

                        return $sum;
                    },
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ];

            break;
    }
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => $columns,
    ]); ?>
</div>
