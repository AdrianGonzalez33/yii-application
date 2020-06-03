<?php


namespace frontend\controllers;

use common\models\Articulo;
use common\models\Categoria;
use common\models\Comentario;
use common\models\User;
use dvamigos\Yii2\Notifications\Notification;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;

class ArticuloController extends Controller{
    public function actionNotification(){
        if(Yii::$app->request->post()){
            $user = User::findOne(Html::encode($_POST["id_user"]));
            yii::$app->notifications->push('new_user', ['username' => $user->getUserName()]);
            Yii::$app->getSession()->setFlash('success', 'Subscripción con éxito');
            return $this->redirect('index');
        }
    }
    public function actionRemovenotification(){
        if(Yii::$app->request->post()){
            $model = new Notification();
            $user = User::findOne(Html::encode($_POST["id_user"]));
            $model = Notification::findIdentity($user->getId());
            $model->delete();
            Yii::$app->getSession()->setFlash('success', 'Desuscripción realizada con éxito');
            return $this->redirect('index');
        }
    }

    public function consultadSuscripcion($username){
        $table = new Notification();
        $query = "SELECT * FROM notificacion WHERE id_user LIKE '%$username%'";
        $model = $table->findBySql($query)->all();
        return $this->render('index', ['notification' => $model]);
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
     * Devuelve todas las categorias distintas contenidas en la tabla articulos
     * @return array
     */
    public function getCategorias(){
        return Articulo::find()->select('categoria')->distinct()->indexBy('categoria')->column();
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
            //<------------   Comentarios pertenecientes al articulo  ---------->
            $comentarios = Comentario::find()->select('*')->from('comentario')->where(['id_articulo' =>  $model->id_articulo])->all();

            //<------------   cantidad total de articulos  ---------->
            $cantidadArticulos = Articulo::find()->count('*');

            //<------------   cantidad de articulos por categoria ---------->
            $categorias = Categoria::find()->select('nombre_categoria')->distinct()->orderBy('nombre_categoria ASC')->indexBy('nombre_categoria')->column();
            foreach($categorias as $Categoria=> $nombreCategoria){
                $categorias[$Categoria]= Articulo::find()->select('nombre_categoria')->where(['categoria' => $nombreCategoria])->count('*');
            }
            //<------------   articulos populares ---------->
            $articulosPopulares = $model->find()->where(['popular' => true ])->orderBy('creado DESC')->all();

            //<------------   articulos relacionados ---------->
            $articulosRelacionados = $model->find()->where(['categoria' => $model->categoria ])->orderBy('creado DESC')->all();

            return $this->render("post",["model" => $model , 'comentarios' => $comentarios, "cantidadArticulos"=>$cantidadArticulos, "categorias"=>$categorias, "articulosPopulares"=>$articulosPopulares, "articulosRelacionados"=>$articulosRelacionados]);
        }
    }

    /**
     * Muestra los articulos en el blog que pertenecen a dicha categoria
     * @return string
     */
    public function actionCategory(){
        $table = new Articulo();
        $categoria = null;
        $tableCategoria = new Categoria();
        $numArticulos=1;

        //<------------   categoria id pasada  ---------->
        $categoria = Yii::$app->request->get('id');

        //<------------   categoria excogida  objeto---------->
        $categoriaObjeto = $tableCategoria->find()->where(['nombre_categoria' => $categoria])->orderBy('nombre_categoria')->all();

        //<------------   articulos de la categoría excogida ---------->
        $articulos = Articulo::find()->select('*')->from('articulo')->where(['categoria' => $categoria])->orderBy('creado DESC')->all();

        //<------------   cantidad total de articulos  ---------->
        $cantidadArticulos = Articulo::find()->count('*');

        //<------------   cantidad de articulos por categoria ---------->
        $categorias = Categoria::find()->select('nombre_categoria')->distinct()->orderBy('nombre_categoria ASC')->indexBy('nombre_categoria')->column();
        foreach($categorias as $Categoria=> $nombreCategoria){
            $categorias[$Categoria]= Articulo::find()->select('nombre_categoria')->where(['categoria' => $nombreCategoria])->count('*');
        }
        //<------------   articulos populares ---------->
        $articulosPopulares = $table->find()->where(['popular' => true ])->orderBy('creado DESC')->all();
        //<------------  pulsan boton cargar más articulos ---------->
        if(Yii::$app->request->get()){
            $categoria = Html::encode($_GET["id"]);
            $numArticulos = Html::encode($_GET["numArticulos"]);
            return $this->render("category", ["numArticulos"=>$numArticulos, "articulos" => $articulos, "categoria"=>$categoria, "cantidadArticulos"=>$cantidadArticulos, "categorias"=>$categorias, "articulosPopulares"=>$articulosPopulares, "objeto"=>$categoriaObjeto]);
        }
        return $this->render("category", ["numArticulos"=>$numArticulos, "articulos" => $articulos, "categoria"=>$categoria, "cantidadArticulos"=>$cantidadArticulos, "categorias"=>$categorias, "articulosPopulares"=>$articulosPopulares, "objeto"=>$categoriaObjeto]);
    }
    /**
     * Muestra articulos al blog
     * @return string
     */
    public function actionIndex(){
        $numArticulos=1;
        $table = new Articulo();

        //<------------   todos los articulos ---------->
        $model = $table->find()->orderBy('creado DESC')->all();

        //<------------   cantidad total de articulos  ---------->
        $cantidadArticulos = Articulo::find()->count('*');

        //<------------   articulos populares ---------->
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
        //<------------  pulsan boton cargar más articulos ---------->
        if(Yii::$app->request->get()){
            $numArticulos = Html::encode($_GET["numArticulos"]);
            return $this->render("index", ["model" => $model, "articulosPopulares"=>$articulosPopulares, 'categorias' => $categorias, 'cantidadArticulos'=>$cantidadArticulos,
                'articulosPorCategorias'=>$articulosPorCategorias, 'numArticulos'=>$numArticulos]);
        }
        return $this->render("index", ["model" => $model, "articulosPopulares"=>$articulosPopulares, 'categorias' => $categorias, 'cantidadArticulos'=>$cantidadArticulos,
            'articulosPorCategorias'=>$articulosPorCategorias, 'numArticulos'=>$numArticulos]);
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