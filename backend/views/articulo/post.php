<?php
use common\models\User;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

$id = (Yii::$app->user->identity);
$user=\common\models\User::findIdentity($id);
if($user !=null){
    $user= $user->getId();
}
$img = Url::to('@web/uploads/');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Articulo</title>
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
            <img class="img-fluid rounded" src=<?= $img.$model->imagen ?> alt="Card image cap">

            <hr>

            <!-- Post Content -->
            <p><?=$model->contenido ?></p>

            <hr>

            <hr>
            <!-- Comments Form -->
            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">Deja un comentario:</h5>
                <div class="card-body">
                    <?php Pjax::begin(['id'=>'id-pjax', 'enablePushState' => false]); ?>
                    <?= $form =Html::beginForm(["comentario/create"], 'post', ['data-pjax' => "", 'class' => 'form-inline']); ?>
                    <div class="form-group">
                        <?= Html::hiddenInput('id_articulo', $model->id_articulo)?>
                        <?= Html::hiddenInput('id_user', $user)?>
                        <?= Html::textarea('contenido_comentario')?>
                    </div>
                    <?php
                    if($user!=null) {
                        echo '<button type="submit" class="btn btn-primary"> Enviar</button>';
                    }else {
                        echo '<button type="submit" class="btn btn-primary" disabled>Bloquedo</button></p>Es necesario estar registrado para poder comentar.</p>';
                    }
                    ?>
                    <?= Html::endForm() ?>
                    <h3 id="success" class="d-none">Comentario enviado con éxito, pendiente de ser validado.</h3>
                    <h3 id="fail" class="d-none">Hubo un error al enviar el comentario, pruebe más tarde.</h3>
                    <?php Pjax::end(); ?>
                </div>
            </div>
            <?php foreach($comentarios as $comentario): ?>
                <?php if($comentario->verificado){ ?>
                <!-- Single Comment -->
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                    <div class="media-body">
                        <h5 class="mt-0"><?=User::findIdentity(($comentario->getIdUser()))->username ?></h5>
                        <?=$comentario->getConenido() ?>
                    </div>
                </div>
            <?php } endforeach ?>
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
    </div>
</div>
</body>
</html>
<script>
    var msgSuccess=document.getElementById("success");
    var msgFail=document.getElementById("fail");
    var  url = window.location.href;
    var regex = new RegExp('[?&]' + 'enviado' + '(=([^&#]*)|&|#|$)');
    var  results = regex.exec(url);
    var element;
    // console.log((results[2]));
    if(results[2]==1){
        msgSuccess.classList.remove("d-none");
        element = document.querySelector("#success");
    }
    if(results[2]==0){
        msgFail.classList.remove("d-none");
        element = document.querySelector("#fail");
    }

    // scroll to element
    element.scrollIntoView({block:"center"});
</script>