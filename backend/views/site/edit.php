<?php

use common\models\Articulo;
use yii\widgets\ActiveForm;

$varAutor = [  Yii::$app->user->identity->username => Yii::$app->user->identity->username, 'Anónimo' => 'Anónimo']; //array con opciones del drpDown

?>
    <h1>Modificar Artículo</h1>

<?php $form = ActiveForm::begin([
    "method" => "put",
    'enableClientValidation' => true,
]);
?>
    <div class="form-group"><?= $form->field($model, "id_articulo")->input("text") ?></div>

    <div class="form-group"><?= $form->field($model, "titulo")->input("text") ?></div>

    <div class="form-group"><?= $form->field($model, "contenido")->input("text") ?></div>

    <div class="form-group"> <?= $form->field($model, "autor")->dropDownList($varAutor, ['prompt' => 'Seleccione Uno' ]); ?></div>

    <div class="form-group"><?= $form->field($model, 'categoria')->textInput(['maxlength' => true]) ?></div>

    <div class="form-group"><?= $form->field($model, "file")->fileInput() ?></div>

    <div><input type="submit" value="Modificar" class="btn btn-primary" >

    <input type="reset" value="Cancelar" class="btn btn-primary" onClick="window.location = 'http://backend.local:8080/index.php?r=site%2Farticulos'" /></div>

<?php $form->end() ?>

