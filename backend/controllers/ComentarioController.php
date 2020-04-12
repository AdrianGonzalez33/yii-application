<?php

namespace backend\controllers;

use app\models\Buscador;
use Yii;
use common\models\Comentario;
use yii\db\StaleObjectException;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComentarioController implements the CRUD actions for Comentario model.
 */
class ComentarioController extends Controller{
    /**
     * {@inheritdoc}
     */
    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Comentario models.
     * @return mixed
     */
    public function actionIndex(){
        $table = new Comentario();
        $model = $table->find()->all(); //carga todos los articulos
        $form = new Buscador();
        $search = null;

        if(Yii::$app->request->post()){
            $comentario = $this->findModel( (int) Html::encode($_POST["checkId"]));
            $valor = ($comentario->verificado ? false : true);
            $comentario->verificado = $valor;
            $comentario->save(false);
            $model = $table->find()->all();
        }

        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->busqueda);
                $query = "SELECT * FROM comentario WHERE id_comentario LIKE '%$search%' OR ";
                $query .= "id_user LIKE '%$search%' OR verificado LIKE '%$search%'";
                $model = $table->findBySql($query)->all();
            } else {
                $form->getErrors();
            }
        }
        return $this->render("index", ["model" => $model, "form" => $form, "search" => $search]);
    }

    /**
     * Displays a single Comentario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Comentario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        $model = new Comentario();
        if(Yii::$app->request->post()){
            $enviado=false;
            $model->id_articulo = Html::encode($_POST["id_articulo"]);
            $model->id_user = Html::encode($_POST["id_user"]);
            $model->contenido_comentario = Html::encode($_POST["contenido_comentario"]);
            $model->creado = time();
            if($model->save()){
                $enviado = true;}
            Yii::$app->response->redirect(['../../articulo/post/'.$model->id_articulo, "enviado"=>$enviado]);
//            return $this->renderAjax('../../articulo/post/'.$model->id_articulo, ["enviado"=>$enviado]);
        }else{
            $model->getErrors();
        }

    }
    /**
     * Updates an existing Comentario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id){
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_comentario]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
            $id_comentario = Html::encode($_POST["id_comentario"]);
            if( (int) $id_comentario) {
                $this->findModel($id_comentario)->delete();
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
     * Finds the Comentario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comentario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id){
        if (($model = Comentario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}