<?php

use common\models\Categoria;
use yii\widgets\ActiveForm;

?>
    <h1>Modificar Categoría</h1>

<?php $form = ActiveForm::begin([
    "method" => "put",
    'enableClientValidation' => true,
]);
?>

    <div class="form-group">

        <div><?= $form->field($model, 'nombre_categoria')->textInput(['maxlength' => true]) ?></div>

        <div><?= $form->field($model, 'imagen')->textInput(['maxlength' => true]) ?></div>

        <div><input type="submit" value="Modificar" class="btn btn-primary" >

            <a class="btn btn-primary" href="http://backend.test/categoria/index" role="button">Cancelar</a></div>

    </div>
<?php $form->end() ?>