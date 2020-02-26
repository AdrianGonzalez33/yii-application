<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;

$this->title = 'Lista de usuarios';
?>

<h3>Lista de Usuarios</h3>
<table class="table table-bordered">
    <tr>
        <th>Id Usuario</th>
        <th>contraseña</th>
        <th>email</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->username ?></td>
        <td><?= $row->auth_key ?></td>
        <td><?= $row->email ?></td>
    </tr>
    <?php endforeach ?>
</table>