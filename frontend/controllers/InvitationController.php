<?php

namespace frontend\controllers;

use Yii;
use app\models\Invitation;
use app\models\InvitationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rbac\ManagerInterface;

/**
 * InvitationController implements the CRUD actions for Invitation model.
 */
class InvitationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'create', 'update', 'delete', 'index'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['admin','user'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['admin','user'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin','user'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Invitation models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('actionAdmin')){
            $searchModel = new InvitationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            //$user_role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'userRole' => 1,
            ]);
        }
        elseif (\Yii::$app->user->can('actionUser')){
            $searchModel = new InvitationSearch();
            $dataProvider = $searchModel->searchuser(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'userRole' => 0,
            ]);
        }
        else{
            echo("У вас нет прав");
        }

    }
/*
    public function actionIndexuser()
    {
	    if (\Yii::$app->user->can('viewOwnInvitation')){
    		$searchModel = new InvitationSearch();
    		$dataProvider = $searchModel->searchuser(Yii::$app->request->queryParams);

    		return $this->render('index', [
    		    'searchModel' => $searchModel,
    		    'dataProvider' => $dataProvider,
    		]);
	    }
    }
*/
    /**
     * Displays a single Invitation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Invitation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invitation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Invitation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Invitation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     *//*
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Invitation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invitation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invitation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
