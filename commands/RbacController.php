<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $role = $auth->createRole('admin');
        $role->description = 'АдминИстратор';
        $auth->add($role);

        $role = $auth->createRole('user');
        $role->description = 'Пользователь';
        $auth->add($role);
    }
}