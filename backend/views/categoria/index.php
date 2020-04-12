<?php

/* @var $this yii\web\View */

use common\models\Articulo;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Lista de categorias';
?>

<!--tabla categoria -->
<div class="container">
    <!--buscador -->
    <?php $formularioBusqueda = ActiveForm::begin([
        'method' => "get",
        'enableClientValidation' => true,
        'action' => Url::toRoute("categoria/index"),
    ]);

    ?>
    <!--buscador -->
    <div class="card my-4">
        <h5 class="card-header">Search</h5>
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
    <!--tabla categoria -->
    <table class="table table-striped table-bordered">
        <tr>
            <th>Id categoria</th>
            <th>Nombre categoria</th>
            <th></th>
            <th></th>
        </tr>

        <!--setea los datos-->
        <?php foreach($model as $row): ?>
            <tr>
                <td><?= $row->id_categoria ?></td>
                <td><?= $row->nombre_categoria ?></td>

                <!--editar y eliminar categorias-->
                <td><a href="<?= Url::toRoute(["categoria/edit/", "id" => $row->id_categoria]) ?>">Editar</a></td>
                <?php if(Articulo::find()->select('nombre_categoria')->where(['categoria' => $row->nombre_categoria])->count('*') == 0) { ?>
                <td><a href="#" data-toggle="modal" data-target="#id_categoria<?= $row->id_categoria ?>">Eliminar</a>
                    <div class="modal fade" role="dialog" aria-hidden="true" id="id_categoria<?= $row->id_categoria ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar categoria</h4>
                                </div>
                                <div class="modal-body">
                                    <p>¿Realmente deseas eliminar la categoria con id <?= $row->id_categoria ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <?= Html::beginForm(Url::toRoute("categoria/delete"), "DELETE") ?>
                                    <input type="hidden" name="id_categoria" value="<?= $row->id_categoria ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                                    <?= Html::endForm() ?>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </td>
            </tr>
        <?php }else{
                echo
                    '<td><a href="#bannerformmodal"" data-toggle="modal" data-target="#id_categoria'.$row->id_categoria.'">Eliminar</a>
                    <div class="modal fade" role="dialog" aria-hidden="true" id="id_categoria'.$row->id_categoria.'">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Eliminar articulo</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <p>No puedes eliminar categorias con articulos</p>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->';
            }


        endforeach ?>
    </table>
</div>
</div>