<?php

use common\models\Categoria;
use yii\widgets\ActiveForm;
use \coderius\pell\Pell;

$varAutor = [  Yii::$app->user->identity->username => Yii::$app->user->identity->username, 'Anónimo' => 'Anónimo']; //array con opciones del dropDown
$varCategoria = Categoria::find()->select('nombre_categoria')->distinct()->indexBy('nombre_categoria')->column();

?>
    <h1>Modificar Artículo</h1>

<?php $form = ActiveForm::begin([
    "method" => "put",
    'enableClientValidation' => true,
    "options" => ["enctype" => "multipart/form-data"],
]);
?>

    <div class="form-group">

        <div><?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?></div>

        <div><?= $form->field($model, 'contenido')->widget(Pell::className(), []);?></div>

        <div><?= $form->field($model, "autor")->dropDownList($varAutor, ['prompt' => 'Seleccione Uno' ,'class'=>"dropdown-toggle" ]); ?></div>

        <div><?= $form->field($model, "categoria")->dropDownList($varCategoria, ['prompt' => 'Seleccione Uno' ,'id'=>'lista','class'=>"dropdown-toggle" ])?></div>

        <div><?= $form->field($model, "archivo")->fileInput() ?></div>

        <div><input type="submit" value="Modificar" class="btn btn-primary" >

            <a class="btn btn-primary" href="http://backend.test/articulo/articulos" role="button">Cancelar</a></div>

    </div>
<?php $form->end() ?>


