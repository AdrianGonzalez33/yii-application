<?php


namespace backend\controllers;

use common\models\Categoria;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class CategoriaController extends Controller{

    protected function findModel($id)    {
        if (($model = Categoria::findOne($id)) !== null){
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionIndex(){
        $model = new Categoria();
        $model = $model->find()->all();
        return $this->render("index", ["model" => $model]);
    }
    /**
     * Devuelve todas las categorias distintas contenidas en la tabla articulos
     * @return array
     */
    public function getCategorias(){
        return Categoria::find()->select('nombre_categoria')->distinct()->indexBy('nombre_categoria')->column();
    }

    public function actionCreate() {
        $model = new Categoria();
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            if($model->save()){
                echo 1;
            }else{
                echo 0;
            }
            //$this->redirect("../articulo/create");
        }else {
            return $this->renderAjax('create', ['model' => $model]);
        }
    }
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [], //solo permitidos sin logear
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create', 'index'], //permitidos logeados
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
}