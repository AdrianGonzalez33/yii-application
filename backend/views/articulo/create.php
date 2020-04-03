<?php
use common\models\Categoria;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \coderius\pell\Pell;
use yii\bootstrap\Modal;

$varAutor = [  Yii::$app->user->identity->username => Yii::$app->user->identity->username, 'Anónimo' => 'Anónimo']; //array con opciones del drpDown
$varCategoria = Categoria::find()->select('nombre_categoria')->distinct()->indexBy('nombre_categoria')->column();

?><h1>Crear Artículo</h1>

<?php $form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true,
    "options" => ["enctype" => "multipart/form-data"],
]);
?>
    <div class="form-group">

        <div><?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?></div>

        <div><?= $form->field($model, 'contenido')->widget(Pell::className(), [])?></div>

        <div><?= $form->field($model, "autor")->dropDownList($varAutor, ['prompt' => 'Seleccione Uno' ,'class'=>"dropdown-toggle" ]) ?></div>

        <div><?= $form->field($model, "categoria")->dropDownList($varCategoria, ['prompt' => 'Seleccione Uno' ,'id'=>'lista','class'=>"dropdown-toggle" ])?>

        <p><?= Html::button('Crear categoria',['value'=>Url::to('http://backend.test/categoria/create'),'class'=>'btn btn-success','id'=>'modalButton'])?> </p>
            <?php
                Modal::begin([
                        'header'=>'<h4>Categoria</h4>',
                        'id'=>'modal',
                        'size'=>'modal-lg',
                        //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
                ]);
                echo "<div id='modalContent'></div>";
                Modal::end();
            ?>
        </div>

        <div><?= $form->field($model, "archivo")->fileInput() ?></div>

        <div><input type="submit" value="Crear" class="btn btn-primary" >

            <a class="btn btn-primary" href="http://backend.test/articulo/articulos" role="button">Cancelar</a></div>

    </div>
<?php $form->end() ?>

