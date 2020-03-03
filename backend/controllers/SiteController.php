<?php
namespace backend\controllers;

use common\models\LoginForm;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Articulo;
use yii\helpers\Html;
use app\models\FormUpload;
use yii\web\UploadedFile;


/**
 * Site controller
 */
class SiteController extends Controller{
    /**
     * Displays blog.
     *
     * @return string
     */
    public function actionIndex(){ // carga articulos al blog
        $table = new Articulo();
        $model = $table->find()->all();
        return $this->render("index", ["model" => $model]);
    }
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
                //$imagen = UploadedFile::getInstance($model,"imagen");
                /*$imagenName = 'stu_'.$model->id_articulo.'.'.$imagen->getExtension();
                $imagen->saveAs(''.$imagenName);*/
                $model = $model->find()->all();
                return $this->render("articulos", ["model" => $model]);

            }else{
                $model->getErrors();
            }
        }

        return $this->render("blog", ['model' => $model, 'msg' => $msg]);
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
        return $this->render("edit", ['model' => $model, "msg"=>$msg]);
    }

    public function actionDelete(){ //borrar articulos
        if(Yii::$app->request->post()){
            $id_articulo = Html::encode($_POST["id_articulo"]);
            if((int) $id_articulo) {
                $this->findModel($id_articulo)->delete();
                //Articulo::deleteAll("id_articulo=:id_articulo", [":id_articulo" => $id_articulo]);
                return $this->redirect(["site/articulos"]);
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
                        'actions' => ['logout', 'articulos','blog', 'usuarios', 'index', 'upload'], //permitidos logeados
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
     * Logout action.
     *
     * @return string
     */
    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }
}

