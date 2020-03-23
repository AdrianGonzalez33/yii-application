<?php

use yii\widgets\ActiveForm;
use \coderius\pell\Pell;

$varAutor = [  Yii::$app->user->identity->username => Yii::$app->user->identity->username, 'Anónimo' => 'Anónimo']; //array con opciones del drpDown

?><h1>Crear Artículo</h1>

<?php $form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true,
    "options" => ["enctype" => "multipart/form-data"],
]);
?>

    <div class="form-group">

        <div><?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?></div>

        <div><?= $form->field($model, 'contenido')->widget(Pell::className(), []);?></div>

        <div><?= $form->field($model, "autor")->dropDownList($varAutor, ['prompt' => 'Seleccione Uno' ,'class'=>"dropdown-toggle" ]); ?></div>

        <div><?= $form->field($model, 'categoria')->textInput(['maxlength' => true]) ?></div>

        <div><?= $form->field($model, "archivo")->fileInput() ?></div>

        <div><input type="submit" value="Crear" class="btn btn-primary" >

            <a class="btn btn-primary" href="http://backend.test/articulo/articulos" role="button">Cancelar</a>

    </div>
<?php $form->end() ?>