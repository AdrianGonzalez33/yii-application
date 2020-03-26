<?php
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
$this->title = 'crear categoria';
?>

<h1>Crear Categoría</h1>

<?php $form = ActiveForm::begin([
    'id'=>$model->formName(),
    "method" => "post",
    'enableClientValidation' => true,
]);
?>
<div class="form-group">
    <div><?= $form->field($model, 'nombre_categoria')->textInput(['id' => "categoria"])?></div>
    <div><input type="submit" value="Crear" class="btn btn-primary" data-target="modal">
        <input type="reset" value="Cancelar" class="btn btn-primary" data-dismiss="modal"></button>
    </div>
</div>
<?php $form->end() ?>
<?php $script = <<< JS
$('form#{$model->formName()}').on('beforeSubmit',function(e){
    var \$form= $(this);
    $.post(
        \$form.attr("action"), //serialize yii2 form
        \$form.serialize()
    )
        .done(function(result){
        if(result == 1){
            $(document).find('#modal').modal('hide');
            //$.pjax.reload({container:'#commodity-grid'});
            $('#lista').append('<option selected>' + $("#categoria").val() + '</option>');
            
        }else{
            $(\$form).trigger("reset");
        }
        }).fail(function()
        {
            console.log("server error");
        });
    return false;
});
JS;
$this->registerJs($script);


