<?php


namespace backend\controllers;

use yii\db\StaleObjectException;
use app\models\Buscador;
use common\models\Categoria;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class CategoriaController extends Controller{

    protected function findModel($id)    {
        if (($model = Categoria::findOne($id)) !== null){
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Carga la tabla con los categorias en lista categorias
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex(){
        $table = new Categoria();
        $model = $table->find()->all(); //carga todas las categorias
        $form = new Buscador();
        $search = null;

        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->busqueda);
                $query = "SELECT * FROM categoria WHERE id_categoria LIKE '%$search%' OR ";
                $query .= "nombre_categoria LIKE '%$search%'";
                $model = $table->findBySql($query)->all();
            } else {
                $form->getErrors();
            }
        }
        return $this->render("index", ["model" => $model, "form" => $form, "search" => $search]);
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

    /**
     * Delete categoria.
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(){ //borrar categorias
        if(Yii::$app->request->post()){
            $id_categoria = Html::encode($_POST["id_categoria"]);
            if((int) $id_categoria) {
                $this->findModel($id_categoria)->delete();
                return $this->redirect(["index"]);
            }
        }else{
            return $this->redirect(["index"]);
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