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
</head>
<h3>Lista de Usuarios</h3>
<div class="card my-4">
    <table class="table table-striped table-bordered">
        <tr>
            <th>Id Usuario</th>
            <th>email</th>
        </tr>
        <?php foreach($model as $row): ?>
        <tr>
            <td><?= $row->username ?></td>
            <td><?= $row->email ?></td>
        </tr>
        <?php endforeach ?>
    </table>
</div>