<?php

use common\models\Articulo;
use yii\helpers\Html;
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

    <div><input type="submit" value="Modificar" class="btn btn-primary" onClick="window.location = 'http://backend.local:8080/index.php?r=site%2Findex'" />

    <input type="reset" value="Cancelar" class="btn btn-primary" onClick="window.location = 'http://backend.local:8080/index.php?r=site%2Findex'" /></div>

<?php $form->end() ?>