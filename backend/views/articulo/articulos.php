<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Lista de Articulos';

?>

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("site/articulos"),
    "enableClientValidation" => true,
]);
?>
<head>
    <style>
        td{
            text-align:left;
        }
    </style>
</head>
<h3>Lista de Artículos</h3>
<table class="table table-bordered">
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
            $input = strip_tags($row->contenido);
            $config = HTMLPurifier_Config::createDefault();
            $config->set('Core.Encoding', 'ISO-8859-1');
            $config->set('AutoFormat.AutoParagraph', true);
            $config->set('HTML.Allowed', 'b,p[align],div,a[target|href]');
            $def = $config->getHTMLDefinition(true);
            $def->addAttribute('a', 'target', new HTMLPurifier_AttrDef_Enum(
                array('_blank')
            ));
            $purifier = new HTMLPurifier($config);
            $output= $purifier->purify($input);
            // reducir texto
            if(strlen($output) >= 60){
                $resumen = substr($input,0,strrpos(substr($input,0,60)," "))."...";
            }else{
                $resumen = $output;
            }
            ?>
            <td><?=$resumen?></td>
            <td><a href="<?= Url::toRoute(["articulo/edit", "id_articulo" => $row->id_articulo]) ?>">Editar</a></td>
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
                                <?= Html::beginForm(Url::toRoute("articulo/delete"), "POST") ?>
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