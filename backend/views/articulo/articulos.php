<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Lista de Articulos';
?>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<div class="container">
    <!--buscador -->
    <?php $formularioBusqueda = ActiveForm::begin([
        'method' => "get",
        'enableClientValidation' => true,
        'action' => Url::toRoute("articulo/articulos"),
    ]);
    ?>

    <h3>Lista de Artículos</h3>
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
        <tr>
            <th>Id Articulo</th>
            <th>titulo</th>
            <th>categoría</th>
            <th>autor</th>
            <th>contenido</th>
            <th>popular</th>
            <th class='text-center'>Enlace</th>
            <th class='text-center'>Editar</th>
            <th class='text-center'>Eliminar</th>
        </tr>

        <!--setea los datos-->
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

                <!--actualiza popular-->
                <?= Html::beginForm(['articulo/articulos'], 'post', ['id' => 'formCheck']) ?>
                <?= Html::hiddenInput('checkId')?>
                <?php
                if($row->popular) {
                    echo"<td class='text-center'><input type='checkbox' id='myCheck' value='$row->id_articulo' onclick='checkUpdate(this)' checked ></td>";
                }else {
                    echo"<td class='text-center'><input type='checkbox' id='myCheck' value='$row->id_articulo' onclick='checkUpdate(this)' ></td>";
                }
                ?>
                <?= Html::endForm() ?>

                <!--enlaces -->
                <td class="text-center"><a href="http://backend.test/articulo/post/<?= $row->id_articulo ?>" id="#{item.name}" class="fa fa-eye" ></td>

                <!--editar y eliminar articulos-->
                <td  class='text-center'><a href="<?= Url::toRoute(["articulo/edit/", "id" => $row->id_articulo]) ?>" id="#{item.name}" class="fa fa-edit" ></td>
                <td  class='text-center'><a href="#" data-toggle="modal" data-target="#id_articulo<?= $row->id_articulo ?>" id="#{item.name}" class="glyphicon glyphicon-trash"></a>
                    <div class="modal fade" role="dialog" aria-hidden="true" id="id_articulo<?= $row->id_articulo ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Eliminar articulo</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Realmente deseas eliminar al articulo con id <?= $row->id_articulo ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <?= Html::beginForm(Url::toRoute("articulo/delete"), "DELETE") ?>
                                    <input type="hidden" name="id_articulo" value="<?= $row->id_articulo ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
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

<script>
    function checkUpdate(mycheck){
        console.log(mycheck.value);
        document.getElementsByName("checkId")[0].value= mycheck.value;
        document.getElementById("formCheck").submit();
    }
</script>
