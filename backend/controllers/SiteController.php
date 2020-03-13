<?php
namespace backend\controllers;

use common\models\LoginForm;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller{
    /**
     * Displays redirige a la pagina principal.
     *
     * @return string
     */
    public function actionIndex(){
        return $this->redirect(["articulo/index"]);
    }
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error',], //solo permitidos sin logear
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'articulos','blog', 'usuarios', 'index', ], //permitidos logeados
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin(){
        if (!Yii::$app->user->isGuest){
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()){
            return $this->goBack();
        }else{
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }
}

