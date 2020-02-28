<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$varAutor = [  Yii::$app->user->identity->username => Yii::$app->user->identity->username, 'Anónimo' => 'Anónimo']; //array con opciones del drpDown

?>
    <h1>Modificar Artículo</h1>
    <h3><?= $msg ?></h3>

<?php $form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true,
]);
?>
    <div class="form-group"><?= $form->field($model, "titulo")->input("text") ?></div>

    <div class="form-group"><?= $form->field($model, "contenido")->input("text") ?></div>

    <div class="form-group"> <?= $form->field($model, "autor")->dropDownList($varAutor, ['prompt' => 'Seleccione Uno' ]); ?></div>

<?= Html::submitButton("Modificar", ["class" => "btn btn-primary"]) ?>
<?= Html::resetButton("Cancelar", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>
