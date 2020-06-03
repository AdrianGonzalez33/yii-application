<?php


namespace backend\controllers;

use app\models\Buscador;
use common\models\Articulo;
use common\models\Categoria;
use common\models\Comentario;
use common\models\User;
use dvamigos\Yii2\Notifications\Notification;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\web\UploadedFile;

class ArticuloController extends Controller{
    function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);

        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

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
     * Muestra articulos al blog antiguo
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

        //<------------   actualiza la casilla populares  ---------->
        if(Yii::$app->request->post()){
            $articulo = $this->findModel( (int) Html::encode($_POST["checkId"]));
            $valor = ($articulo->popular ? false : true);
            $articulo->popular = $valor;
            $articulo->save(false);
            $model = $table->find()->all();
        }
        //<------------   Buscador ---------->
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->busqueda);
                $query = "SELECT * FROM articulo WHERE id_articulo LIKE '%$search%' OR ";
                $query .= "categoria LIKE '%$search%' OR titulo LIKE '%$search%'OR autor LIKE '%$search%'";
                $model = $table->findBySql($query)->all();
            } else {
                $form->getErrors();
            }
        }
        return $this->render("articulos", ["model" => $model, "form" => $form, "search" => $search]);
    }
    /**
     * Return cantidad de articulos de una categoria.
     *
     * @return string
     */
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
        $tablaNotificaciones = new Notification();
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
                $notificaciones = $tablaNotificaciones->find()->all();
                $ids =array();
                foreach($notificaciones as $noti ){
                    array_push($ids, $noti->getUserId());
                }
                $stringUsuarios = implode(",", $ids);
                $userTable = new User();
                $query = "SELECT * FROM user WHERE (`id` IN (1))";
                $usuarios = $userTable->findBySql($query)->all();
                foreach($usuarios as $usuario) {
                    $send = Yii::$app->mailer->compose()
                        ->setFrom('al361882@gmail.com')
                        ->setTo($usuario->getEmail())
                        ->setSubject('Test Message')
                        ->setTextBody('Plain text content. YII2 Application')
                        ->setHtmlBody('<b>HTML content <i>Ram Pukar</i></b>')
                        ->send();
                    if($send){
                        echo "Send";
                    }
                }
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