<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Lista de Comentarios';
?>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<div class="container">
    <!--buscador -->
    <?php $formularioBusqueda = ActiveForm::begin([
        'method' => "get",
        'enableClientValidation' => true,
        'action' => Url::toRoute("comentario/index"),
    ]);

    ?>

    <h3>Lista de Comentarios</h3>
    <!--buscador -->
    <div class="card my-4">
        <h5 class="card-header">Buscar</h5>
        <div class="card-body">
            <div class="input-group">
                <?= $formularioBusqueda->field($form, "busqueda",['errorOptions'=>['tag'=>false]])->textInput(['class' => 'form-control','style' => 'background-color: #fff;','placeholder'=>"Introduce aquí tu búsqueda:"])->label(false)?>
                <span class="input-group-btn">
                        <?= Html::submitButton("Buscar", ["class" => "btn btn-secondary"]) ?>
                      </span>
            </div>
        </div>
    </div>

    <?php $formularioBusqueda->end() ?>
    <!--tabla articulos -->
    <table class="table table-striped table-bordered">
        <tr class="active">
            <th class="text-center">Id</th>
            <th>Artículo</th>
            <th>Usuario</th>
            <th class='text-center'>Enlace</th>
            <th class='text-center'>Verificado</th>
            <th class='text-center'>Eliminar</th>
        </tr>

        <!--setea los datos-->
        <?php foreach($model as $row): ?>
            <tr>
                <td class="text-center"><?= $row->id_comentario ?></td>
                <td><?= \common\models\Articulo::findOne($row->id_articulo )->getTitulo() ?></td>
                <td> <?= \common\models\User::findOne( $row->id_user )->getUserName()?> </td>
                <td class="text-center"><a href="http://backend.test/articulo/post/<?= $row->id_articulo ?>" id="#{item.name}" class="fa fa-eye" ></td>
                <!--actualiza verificado-->
                <?= Html::beginForm(['comentario/index'], 'post', ['id' => 'formCheck']) ?>
                <?= Html::hiddenInput('checkId')?>
                <?php
                if($row->verificado) {
                    echo"<td class='text-center'><input type='checkbox' id='myCheck' value='$row->id_comentario' onclick='checkUpdate(this)' checked ></td>";
                }else {
                    echo"<td class='text-center'><input type='checkbox' id='myCheck' value='$row->id_comentario' onclick='checkUpdate(this)' ></td>";
                }
                ?>
                <?= Html::endForm() ?>

                <!--elimina Comentario-->
                <td class='text-center'><a href="#" data-toggle="modal" data-target="#id_comentario<?= $row->id_comentario ?>"id="#{item.name}" class="glyphicon glyphicon-trash"></a>
                    <div class="modal fade" role="dialog" aria-hidden="true" id="id_comentario<?= $row->id_comentario ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar comentario</h4>
                                </div>
                                <div class="modal-body">
                                    <p>¿Realmente deseas eliminar el comentario con id <?= $row->id_comentario ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <?= Html::beginForm(Url::toRoute("comentario/delete"), "POST") ?>
                                    <input type="hidden" name="id_comentario" value="<?= $row->id_comentario ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                                    <?= Html::endForm() ?>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </td>
            </tr>
            <tr>
                <th>Comentario: </th>
                <td colspan="5"><?= $row->contenido_comentario?></td>
        <?php endforeach ?>
    </table>
</div>
</div>
<script>
    function checkUpdate(mycheck){
        console.log(mycheck.value);
        document.getElementsByName("checkId")[0].value= mycheck.value;
        document.getElementById("formCheck").submit();
    }
</script>