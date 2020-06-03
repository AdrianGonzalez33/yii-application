<?php
use common\models\User;
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
<head>
</head>
<!-- HEADER -->
<header id="header">
    <!-- Top Nav -->
    <div id="nav-logo" style="position:sticky">
        <div class="container" style="position:sticky">
            <!-- logo -->
            <div class="nav-menu pull-left">
                <a href="http://backend.test/articulo/prueba" class="logo">
                    <img src="<?=$img."../img/logo-rojo.svg"?>" class="logo-red" alt="" height="auto" width="150px">
                    <img src="<?=$img."../img/logo-blanco.svg"?>" class="logo-white" alt="" height="auto" width="150px">
                </a>
            </div>
            <!-- /logo -->

            <!-- links -->
            <ul class="nav justify-content-lg-center pull-right">
                <li><a href="#">Alquiler de coches</a></li>
                <li><a href="#">Club Record go</a></li>
                <li><a href="#">Busca tu reserva</a></li>
            </ul>
            <!-- /search & aside toggle -->
        </div>
    </div>
    <hr style="border:1px solid #e33531; border-radius: 5px;margin-top: 0px; margin-bottom: 0px;  margin-left: -100%; margin-right: -100%;">
    <!-- /Top Nav -->

</header>
<!-- /HEADER -->
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