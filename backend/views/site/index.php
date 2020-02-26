<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;

$this->title = 'Lista de usuarios';
?>

<div class="site-index">
    <h3>Lista de Artículos</h3>
    <table class="table table-bordered">
        <tr>
            <th>Id Articulo</th>
            <th>titulo</th>
            <th>contenido</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach($model as $row): ?>
            <tr>
                <td><?= $row->id_articulo ?></td>
                <td><?= $row->titulo ?></td>
                <td><?= $row->contenido ?></td>
                <td><a href="#">Editar</a></td>
                <td><a href="#" data-toggle="modal" data-target="#id_articulo<?= $row->id_articulo ?>">Eliminar</a>
                    <div class="modal fade" role="dialog" aria-hidden="true" id="id_articulo<?= $row->id_articulo ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar articulo</h4>
                                </div>
                                <div class="modal-body">
                                    <p>¿Realmente deseas eliminar al articulo con id <?= $row->id_articulo ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <?= Html::beginForm(Url::toRoute("site/delete"), "POST") ?>
                                    <input type="hidden" name="id_articulo" value="<?= $row->id_articulo ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
