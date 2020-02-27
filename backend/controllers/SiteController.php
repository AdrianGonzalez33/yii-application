<?php
namespace backend\controllers;

use common\models\LoginForm;
use common\models\User;
use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Articulo;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Url;



/**
 * Site controller
 */
class SiteController extends Controller{
    /**
     * Displays listaArticulos.
     *
     * @return string
     */
    public function actionIndex(){ // carga a vista tabla articulos
        $table = new Articulo();
        $model = $table->find()->all();
        return $this->render("index", ["model" => $model]);
    }
    public function actionHola(){
        return $this->render('lista');
    }
    /**
     * Displays listaUsuarios.
     *
     * @return string
     */
    public function actionUsuarios(){ //carga a vista tabla usuarios
        $table = new User();
        $model = $table->find()->all();
        return $this->render("usuarios", ["model" => $model]);
    }

    public function actionBlog(){ // Crear artículo AJAX/JSON
        $model = new Articulo();
        $model->autor = 'Pepe';

        $msg = null;

        if ( $model->load(Yii::$app->request->post() ) ){
            if ($model->validate()){

                $model->save();
                $model = new Articulo();

            }else{
                $model->getErrors();
            }
        }

        return $this->render("blog", ['model' => $model, 'msg' => $msg]);
    }

    public function actionDelete(){ //borrar articulos
        if(Yii::$app->request->post()){
            $id_articulo = Html::encode($_POST["id_articulo"]);
            if((int) $id_articulo){
                if(Articulo::deleteAll("id_articulo=:id_articulo", [":id_articulo" => $id_articulo])){
                    echo "El articulo id $id_articulo eliminado con éxito, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/index")."'>";
                }else{
                    echo "Ha ocurrido un error al eliminar el articulo, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/index")."'>";
                }
            }
            else{
                echo "Ha ocurrido un error al eliminar el articulo, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/index")."'>";
            }
        }else{
            return $this->redirect(["site/index"]);
        }
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
                       'actions' => ['logout', 'index','blog', 'usuarios'], //permitidos logeados
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
