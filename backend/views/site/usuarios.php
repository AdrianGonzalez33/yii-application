<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;

$this->title = 'Lista de usuarios';
?>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<h3>Lista de Usuarios</h3>
<div class="table-responsive">
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
</div>