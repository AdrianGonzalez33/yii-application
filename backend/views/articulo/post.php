<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$form = array();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Articulo</title>


    <!-- Bootstrap comentarios -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


</head>

<body>


<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Post Content Column -->
        <div class="col-lg-8">
            <!-- Title -->
            <h1 class="mt-4"><?=$model->titulo ?></h1>
            <!-- Author -->
            <p class="lead">
                Articulo creado por <?=$model->autor ?>
            </p>

            <hr>

            <!-- Date/Time -->
            <p>Publicado el <?=Yii::$app->formatter->asDate($model->creado)?> a las <?=Yii::$app->formatter->asTime($model->creado)?></p>

            <hr>

            <!-- Preview Image -->
            <img class="img-fluid rounded" src=/<?= $model->imagen ?> alt="">

            <hr>

            <!-- Post Content -->
            <p><?=$model->contenido ?></p>

            <hr>

    <hr>
   <?php $id = (Yii::$app->user->identity);
   $user =\common\models\User::findIdentity($id)?>
    <!-- Comments Form -->
    <div class="card my-4">
        <h5 class="card-header">Leave a Comment:</h5>
        <div class="card-body">

            <?=$form= Html::beginForm(Url::toRoute("comentario/create"), "POST") ?>
                <div class="form-group">
                    <?= Html::hiddenInput('id_articulo', $model->id_articulo)?>
                    <?= Html::hiddenInput('id_user', $user->getId())?>
                    <?= Html::textarea('contenido_comentario') ?>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            <?= Html::endForm() ?>
        </div>
    </div>
        <!-- Single Comment -->
    <div class="media mb-4">
        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
        <div class="media-body">
            <h5 class="mt-0"><?="Usuario con id: ".$user->getId()." y nombre: ".$user->getUserName()." //////// el articulo con id_articulo: ".$model->id_articulo ?></h5>
            texto del comentario
        </div>
    </div>

    <!-- Comment with nested comments -->
    <div class="media mb-4">
        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
        <div class="media-body">
            <h5 class="mt-0">Commenter Name</h5>
            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.

            <div class="media mt-4">
                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                <div class="media-body">
                    <h5 class="mt-0">Commenter Name</h5>
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
            </div>

            <div class="media mt-4">
                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                <div class="media-body">
                    <h5 class="mt-0">Commenter Name</h5>
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>

