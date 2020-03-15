<?php


namespace frontend\controllers;

use common\models\Articulo;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;

class ArticuloController extends Controller{
    /**
     * Logout action.
     * @param integer $id
     * @return Articulo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     * @return string
     */
    protected function findModel($id)    {
        if (($model = Articulo::findOne($id)) !== null){
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Devuelve todas las categorias distintas contenidas en la tabla articulos
     * @return array
     */
    public function getCategorias(){
        return Articulo::find()->select('categoria')->distinct()->indexBy('categoria')->column();
    }

    /**
     * Displays el articulo en post.
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPost(){
        $model = new Articulo();
        if(Yii::$app->request->get()){
            $id_articulo =Html::encode($_GET["id"]);
            $model = $this->findModel($id_articulo);
            return $this->render("post",[ "model" => $model]);
        }
        return $this->render("index");
    }
    /**
     * Displays blog.
     *
     * @return string
     */
    public function actionIndex(){ // carga articulos al blog
        $table = new Articulo();
        $model = $table->find()->all();
        $categorias = $this->getCategorias();
        return $this->render("index", ["model" => $model, 'categorias' => $categorias ]);
    }
    /**
     * Displays categorias en el blog.
     *
     * @return string
     */
    public function actionCategory(){ // carga categoria al blog
        $categoria = null;
        $categoria = Yii::$app->request->get('id');
        $model = Articulo::find()->select('*')->from('articulo')->where(['categoria' => $categoria])->all();
        return $this->render("category", ["model" => $model, "categoria"=>$categoria]);
    }
    /**
     * Displays todos los articulos en listaArticulos.
     *
     * @return string
     */
    public function actionArticulos(){ // carga tabla articulos
        $table = new Articulo();
        $model = $table->find()->all();//->request->getParam('categoria');
        return $this->render("articulos", ["model" => $model]);
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'category','post'], //solo permitidos sin logear
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'category','post'], //permitidos logeados
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