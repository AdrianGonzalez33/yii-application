<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$varAutor = [  Yii::$app->user->identity->username => Yii::$app->user->identity->username, 'Anónimo' => 'Anónimo']; //array con opciones del drpDown

?>
    <h1>Crear Artículo</h1>
    <h3><?= $msg ?></h3>

<?php $form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true,
    "options" => ["enctype" => "multipart/form-data"],
]);
?>
    <div class="form-group"><?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?></div>

    <div class="form-group"><?= $form->field($model, "contenido")->input("text") ?></div>

    <div class="form-group"><?= $form->field($model, "autor")->dropDownList($varAutor, ['prompt' => 'Seleccione Uno' ]); ?></div>

    <div class="form-group"><?= $form->field($model, "imagen")->fileInput() ?></div>

    <div><input type="submit" value="Crear" class="btn btn-primary" >

    <input type="reset" value="Cancelar" class="btn btn-primary" onClick="window.location = 'http://backend.local:8080/index.php?r=site%2Farticulos'" /></div>

<?php $form->end() ?>