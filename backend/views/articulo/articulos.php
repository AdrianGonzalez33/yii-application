<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Lista de Articulos';
?>
<div class="container">
    <!--buscador -->
    <?php $formularioBusqueda = ActiveForm::begin([
        "method" => "get",
        "action" => Url::toRoute("articulo/articulos"),
        "enableClientValidation" => true,
    ]);

    ?>
    <h3>Lista de Artículos</h3>
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
    <!--tabla articulos -->
    <table class="table table-striped table-bordered">
        <tr>
            <th>Id Articulo</th>
            <th>titulo</th>
            <th>categoría</th>
            <th>autor</th>
            <th>contenido</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach($model as $row): ?>
            <tr>
                <td><?= $row->id_articulo ?></td>
                <td><?= $row->titulo ?></td>
                <td><?= $row->categoria?></td>
                <td><?= $row->autor ?></td>
                <?php // limpia codigo html
                $textoPlano = strip_tags($row->contenido);
                // reducir texto
                if(strlen($textoPlano) >= 60){
                    $resumen = substr($textoPlano,0,strrpos(substr($textoPlano,0,60)," "))."...";
                }else{
                    $resumen = $textoPlano;
                }
                ?>
                <td><?=$resumen?></td>
                <td><a href="<?= Url::toRoute(["articulo/edit/", "id" => $row->id_articulo]) ?>">Editar</a></td>
                <td><a href="#" data-toggle="modal" data-target="#id_articulo<?= $row->id_articulo ?>">Eliminar</a>
                    <div class="modal fade" role="dialog" aria-hidden="true" id="id_articulo<?= $row->id_articulo ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar articulo</h4>
                                </div>
                                <div class="modal-body">
                                    <p>¿Realmente deseas eliminar al articulo con id <?= $row->id_articulo ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <?= Html::beginForm(Url::toRoute("articulo/delete"), "DELETE") ?>
                                    <input type="hidden" name="id_articulo" value="<?= $row->id_articulo ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                                    <?= Html::endForm() ?>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    </div>
</div>