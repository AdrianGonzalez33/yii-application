<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ComentarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comentario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_comentario') ?>

    <?= $form->field($model, 'id_articulo') ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 'id_padre') ?>

    <?= $form->field($model, 'contenido_comentario') ?>

    <?php // echo $form->field($model, 'creado') ?>

    <?php // echo $form->field($model, 'modificado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
