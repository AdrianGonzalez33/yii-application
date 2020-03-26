<?php

/* @var $this yii\web\View */

$this->title = 'Lista de categorias';
?>

<!--tabla categoria -->
<table class="table table-striped table-bordered">
    <tr>
        <th>Id categoria</th>
        <th>Nombre categoria</th>
    </tr>
    <?php foreach($model as $row): ?>
        <tr>
            <td><?= $row->id_categoria ?></td>
            <td><?= $row->nombre_categoria ?></td>
            </td>
        </tr>
    <?php endforeach ?>
</table>
