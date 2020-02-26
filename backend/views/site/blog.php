<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
    <h1>Crear Artículo</h1>
    <h3><?= $msg ?></h3>
<?php $form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true,
]);
?>
    <div class="form-group">
        <?= $form->field($model, "titulo")->input("text") ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, "contenido")->input("text") ?>
    </div>

<?= Html::submitButton("Crear", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>