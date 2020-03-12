<?php

use common\models\Articulo;
use yii\widgets\ActiveForm;
use \coderius\pell\Pell;

$varAutor = [  Yii::$app->user->identity->username => Yii::$app->user->identity->username, 'Anónimo' => 'Anónimo']; //array con opciones del drpDown

?>
    <h1>Modificar Artículo</h1>

<?php $form = ActiveForm::begin([
    "method" => "put",
    'enableClientValidation' => true,
]);
?>
<div class="form-group">

    <div><?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?></div>

    <div><?= $form->field($model, 'contenido')->widget(Pell::className(), []);?></div>

    <div><?= $form->field($model, "autor")->dropDownList($varAutor, ['prompt' => 'Seleccione Uno' ,'class'=>"dropdown-toggle" ]); ?></div>

    <div><?= $form->field($model, 'categoria')->textInput(['maxlength' => true]) ?></div>

    <div><?= $form->field($model, "file")->fileInput() ?></div>

    <div><input type="submit" value="Crear" class="btn btn-primary" >
        <input type="reset" value="Cancelar" class="btn btn-primary" onClick="window.location" = 'http://backend.local:8080/articulo/articulos'</div>

</div>

<?php $form->end() ?>

