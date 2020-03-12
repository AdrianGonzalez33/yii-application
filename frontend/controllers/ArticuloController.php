<?php


namespace frontend\controllers;

use common\models\Articulo;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\web\UploadedFile;

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
        $id_articulo = Yii::$app->request->get('id_articulo');
        $model = $this->findModel($id_articulo);
        return $this->render("post", ["model" => $model]);
    }
    /**
     * Displays blog.
     *
     * @return string
     */
    public function actionIndex(){ // carga articulos al blog
        $table = new Articulo();
        $model = $table->find()->all();
        $articulos = $this->getCategorias();
        return $this->render("index", ["model" => $model, 'categorias' => $articulos ]);
    }
    /**
     * Displays categorias en el blog.
     *
     * @return string
     */
    public function actionCategory(){ // carga categoria al blog
        $categoria = null;
        $categoria = Yii::$app->request->get('categoria');
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
    /**
     * Create Articulo.
     *
     * @return string
     */
    public function actionBlog(){
        $model = new Articulo();

        if ($model->load(Yii::$app->request->post() ) ){
            // obtener instancia de uploaded file
            $model->file = UploadedFile::getInstance($model,'imagen');
            $imageName = (string)$model->id_articulo;
            $model->file->saveAs('uploads/'.$imageName.".".$model->file->extension, false);
            //guardar el path en la columna de la base de datos.
            $model->imagen = 'uploads/'.$imageName.".".$model->file->extension;
            //guardamos el time de cuando fue creado
            $model->creado = time();
            $model->modificado = null;
            if ($model->validate()){
                $model->save();
                $model = $model->find()->all();
                return $this->render("articulos", ["model" => $model]);

            }else{
                $model->getErrors();
            }
        }

        return $this->render("blog", ['model' => $model]);
    }

    /**
     * Displays en edit todos los datos
     * de un articulo para modificarlo.
     * @param bool $id_articulo
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionEdit($id_articulo = false){
        if ( $id_articulo ) {
            $model = Articulo::findOne( [ 'id_articulo' => $id_articulo ] );
        } else {
            $model = new Articulo();
        }
        if($model->load(Yii::$app->request->post())){
            $model->file = UploadedFile::getInstance($model,'imagen');
            $imageName = $model->id_articulo;

            $model->file->saveAs('uploads/'.$imageName.".".$model->file->extension, false);
            //guardar el path en la columna de la base de datos.
            $model->imagen = 'uploads/'.$imageName.".".$model->file->extension;
            $model->modificado = time();
            if($model->validate()){
                $model->update();
                $model = $model->find()->all();
                return $this->render("articulos", ["model" => $model]);

            }else{
                $model->getErrors();
            }
        }
        return $this->render("edit", ['model' => $model]);
    }

    /**
     * Delete blog.
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(){ //borrar articulos
        if(Yii::$app->request->post()){
            $id_articulo = Html::encode($_POST["id_articulo"]);
            if((int) $id_articulo) {
                $this->findModel($id_articulo)->delete();
                //Articulo::deleteAll("id_articulo=:id_articulo", [":id_articulo" => $id_articulo]);
                return $this->redirect(["articulos"]);
            }
        }else{
            return $this->redirect(["articulos"]);
        }
    }
    public function actions()
    {
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

}