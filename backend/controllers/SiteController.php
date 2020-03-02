<?php
namespace backend\controllers;

use yii\data\ActiveDataProvider;
use common\models\LoginForm;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Articulo;
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
    public function actionArticulos(){ // carga a vista tabla articulos
        $table = new Articulo();
        $model = $table->find()->all();
        return $this->render("articulos", ["model" => $model]);
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
    /**
     * Create Articulo.
     *
     * @return string
     */
    public function actionBlog(){
        $model = new Articulo();
        $msg = null;
        if ( $model->load(Yii::$app->request->post() ) ){
            if ($model->validate()){
                $model->save();
                $model = $model->find()->all();
                return $this->render("articulos", ["model" => $model]);

            }else{
                $model->getErrors();
            }
        }

        return $this->render("blog", ['model' => $model, 'msg' => $msg]);
    }

    public function actionIndex(){
        return $this->render("index");
    }


    public function actionEdit($id_articulo = false){
        $msg =null;
        if ( $id_articulo ) {
            $model = Articulo::findOne( [ 'id_articulo' => $id_articulo ] );
        } else {
            $model = new Articulo();
        }
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                $model->update();
                $model = $model->find()->all();
                return $this->render("articulos", ["model" => $model]);

            }else{
                $model->getErrors();
            }
        }
        /*if (isset($_POST['modificar'])) {
            $model->update();
        }*/

        return $this->render("edit", ['model' => $model, "msg"=>$msg]);
    }


    public function actionDelete(){ //borrar articulos
        if(Yii::$app->request->post()){
            $id_articulo = Html::encode($_POST["id_articulo"]);
            if((int) $id_articulo){
                if(Articulo::deleteAll("id_articulo=:id_articulo", [":id_articulo" => $id_articulo])){
                    echo "El articulo id $id_articulo eliminado con éxito, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/articulos")."'>";
                }else{
                    echo "Ha ocurrido un error al eliminar el articulo, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/articulos")."'>";
                }
            }
            else{
                echo "Ha ocurrido un error al eliminar el articulo, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/articulos")."'>";
            }
        }else{
            return $this->redirect(["site/articulos"]);
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
                        'actions' => ['logout', 'articulos','blog', 'usuarios', 'index'], //permitidos logeados
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

