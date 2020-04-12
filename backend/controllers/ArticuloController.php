<?php


namespace backend\controllers;

use app\models\Buscador;
use common\models\Articulo;
use common\models\Categoria;
use common\models\Comentario;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\web\UploadedFile;

class ArticuloController extends Controller{

    public function actionIndex(){
        $table = new Articulo();
        //<------------   todos los articulos ---------->
        $model = $table->find()->orderBy('creado DESC')->all();

        //<------------   cantidad total de articulos  ---------->
        $cantidadArticulos = Articulo::find()->count('*');
        $articulosPopulares = $table->find()->where(['popular' => true ])->orderBy('creado DESC')->all();

        //<------------   cantidad de articulos por categoria ---------->
        $categorias = Categoria::find()->select('nombre_categoria')->distinct()->orderBy('nombre_categoria ASC')->indexBy('nombre_categoria')->column();
        foreach($categorias as $Categoria=> $nombreCategoria){
            $categorias[$Categoria]= Articulo::find()->select('nombre_categoria')->where(['categoria' => $nombreCategoria])->count('*');
        }
        //<------------  map Key categoria value array de articulos ---------->
        $articulosPorCategorias = array();
        $categorias2 = Categoria::find()->select('nombre_categoria')->distinct()->orderBy('nombre_categoria ASC')->indexBy('nombre_categoria')->column();
        foreach($categorias2 as $Categoria=> $nombreCategoria) {
            $articulosPorCategorias[$Categoria] = Articulo::find()->where(['categoria' => $nombreCategoria])->orderBy('creado DESC')->all();
        }
        return $this->render("index", ["model" => $model, "articulosPopulares"=>$articulosPopulares, 'categorias' => $categorias, 'cantidadArticulos'=>$cantidadArticulos,
            'articulosPorCategorias'=>$articulosPorCategorias]);
    }

    /**
     * Muestra articulos al blog
     * @return string
     */
    public function actionAntigua(){
        $table = new Articulo();
        $model = $table->find()->orderBy('creado')->all();
        $categorias = Categoria::find()->select('nombre_categoria')->distinct()->indexBy('nombre_categoria')->column();
        return $this->render("antigua", ["model" => $model, 'categorias' => $categorias ]);
    }

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
     * Displays el articulo en post.
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPost(){
        $model = new Articulo();
        if(Yii::$app->request->get()){
            $id_articulo =Html::encode($_GET["id"]);
            $model = $this->findModel($id_articulo);
            $comentarios = Comentario::find()->select('*')->from('comentario')->where(['id_articulo' =>  $model->id_articulo])->all();
            return $this->render("post",["model" => $model , 'comentarios' => $comentarios]);
        }
        return $this->render("index");
    }

    /**
     * Muestra los articulos en el blog que pertenecen a dicha categoria
     * @return string
     */
    public function actionCategory(){
        $categoria = null;
        $categoria = Yii::$app->request->get('id');
        $model = Articulo::find()->select('*')->from('articulo')->where(['categoria' => $categoria])->all();
        return $this->render("category", ["model" => $model, "categoria"=>$categoria]);
    }

    /**
     * Carga la tabla con los articulos en listaArticulos.
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionArticulos(){
        $table = new Articulo();
        $model = $table->find()->all(); //carga todos los articulos
        $form = new Buscador();
        $search = null;

        if(Yii::$app->request->post()){
            $articulo = $this->findModel( (int) Html::encode($_POST["checkId"]));
            $valor = ($articulo->popular ? false : true);
            $articulo->popular = $valor;
            $articulo->save(false);
            $model = $table->find()->all();

        }
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->busqueda);
                $query = "SELECT * FROM articulo WHERE id_articulo LIKE '%$search%' OR ";
                $query .= "categoria LIKE '%$search%' OR titulo LIKE '%$search%'";
                $model = $table->findBySql($query)->all();
            } else {
                $form->getErrors();
            }
        }
        return $this->render("articulos", ["model" => $model, "form" => $form, "search" => $search]);
    }

    public  function getCantidadArticulos($categoria){
        $query = "SELECT COUNT(*) FROM articulo WHERE nombre_categoria LIKE '%$categoria%'";
        return $query;
    }

    /**
     * Create Articulo.
     *
     * @return string
     */
    public function actionCreate(){
        $form = new Buscador();
        $search = null;
        $model = new Articulo();
        if ($model->load(Yii::$app->request->post())){
            $model->archivo = UploadedFile::getInstance($model,'archivo');
            if ($model->validate()){
                $model->creado = time();
                $nombreFichero = $model->archivo->getBaseName();
                $model->archivo->saveAs('uploads/'.$nombreFichero.".".$model->archivo->extension, false);
                $model->imagen = $nombreFichero.".".$model->archivo->extension;
                $model->save();
                $table = $model->find()->all();
                return $this->render("articulos", ["model" => $table, "form" => $form, "search" => $search]);
            }else{
                $model->getErrors();
            }
        }
        return $this->render("create", ['model' => $model]);
    }

    /**
     * Displays en edit todos los datos
     * de un articulo para modificarlo.
     * @param $id_articulo
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEdit(){
        $form = new Buscador();
        $search = null;
        if(Yii::$app->request->get()){
        $id_articulo =Html::encode($_GET["id"]);
        $model = $this->findModel($id_articulo);
            if ($model->load(Yii::$app->request->post())) {
                $model->archivo = UploadedFile::getInstance($model, 'archivo');
                if ($model->validate()) {
                    $model->modificado = time();
                    $nombreFichero = $model->archivo->getBaseName();
                    $model->archivo->saveAs('uploads/' . $nombreFichero . "." . $model->archivo->extension, false);
                    $model->imagen = $nombreFichero . "." . $model->archivo->extension;
                    $model->save();
                    $table = $model->find()->all();
                    return $this->render("articulos", ["model" => $table, "form" => $form, "search" => $search]);
                } else {
                    $model->getErrors();
                }
            }
        }
        return $this->render("edit", ['model' => $model]);
    }

    /**
     * Delete blog.
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(){ //borrar articulos
        if(Yii::$app->request->post()){
            $id_articulo = Html::encode($_POST["id_articulo"]);
            if((int) $id_articulo) {
                $this->findModel($id_articulo)->delete();
                return $this->redirect(["articulos"]);
            }
        }else{
            return $this->redirect(["articulos"]);
        }
    }
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','index','category', 'post','antigua'], //solo permitidos sin logear
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'articulos','create', 'edit','antigua' ], //permitidos logeados
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