<?php

namespace app\controllers;

use app\models\Department;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'roles'   => ['admin'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $this->resetFieldPassword($model);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function resetFieldPassword($model)
    {
        $model->password = null;
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->setScenario(User::SCENARIO_CREATE);
        $transaction = Yii::$app->db->beginTransaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $transaction->rollBack();

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model       = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $transaction->commit();
            $this->resetFieldPassword($model);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $transaction->rollback();
            $this->resetFieldPassword($model);

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->findModel($id)->delete();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }

        return $this->redirect(['index']);
    }

    /**
     * @return array
     */
    public function getItemsForDepartmentField()
    {
        return ArrayHelper::map(Department::find()->asArray()->all(), 'id', 'name');
    }

    public function getItemsForUserRoleField()
    {
        return [
            'admin' => 'Администратор',
            'user'  => 'Пользователь',
        ];
    }
}
