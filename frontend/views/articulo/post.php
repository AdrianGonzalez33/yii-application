<?php

use common\models\Comentario;
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
$id = (Yii::$app->user->identity);
$user=\common\models\User::findIdentity($id);
if($user !=null){
    $user= $user->getId();
}
$img = Url::to('@web/assets/c2257e59/');
$comentarios = Comentario::find()->select('*')->from('comentario')->where(['id_articulo' =>  $model->id_articulo])->all();
?>

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
            <img class="img-fluid rounded" src=<?=$img.$model->imagen ?> alt="Card image cap">

            <hr>

            <!-- Post Content -->
            <p><?=$model->contenido ?></p>

            <hr>

            <hr>
            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">Deja un comentario:</h5>
                <div class="card-body">
                    <?=$form= Html::beginForm(Url::toRoute("comentario/create"), "POST") ?>
                    <div class="form-group">
                        <?= Html::hiddenInput('id_articulo', $model->id_articulo)?>
                        <?= Html::hiddenInput('id_user', $user)?>
                        <?= Html::textarea('contenido_comentario') ?>
                    </div>
                    <?php
                        if($user!=null) {
                            echo '<button type="submit" class="btn btn-primary"> Enviar</button>';
                        }else {
                            echo '<button type="submit" class="btn btn-primary" disabled>Bloquedo</button>';
                        }
                    ?>
                    <?= Html::endForm() ?>
                </div>
            </div>

            <?php foreach($comentarios as $comentario): ?>
                <!-- Single Comment -->
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                    <div class="media-body">
                        <h5 class="mt-0"><?=User::findIdentity(($comentario->getIdUser()))->username ?></h5>
                        <?=$comentario->getConenido() ?>
                    </div>
                </div>
            <?php endforeach ?>
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
