<?php

use common\models\User;
use frontend\assets\BackendAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

$backend = BackendAsset::register($this);
$id = (Yii::$app->user->identity);
$user=\common\models\User::findIdentity($id);
if($user !=null){
    $user= $user->getId();
}
$img = Url::to('@web/assets/d086a17a/');
?>

<body>
<!-- PAGE HEADER -->
<div id="post-header" class="page-header">
    <div class="page-header-bg" style='background-image: url(<?= $img.$model->imagen ?>); data-stellar-background-ratio="0.5"; background-repeat:repeat; background-size: 100% 100%; width:1130px' ></div>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="post-category">
                    <a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $model->categoria, "numArticulos"=>1])?>"><?=$model->categoria ?></a>
                </div>
                <h1><?=$model->titulo ?></h1>
                <ul class="post-meta">
                    <li><a href="author.html"><?=$model->autor ?></a></li>
                    <li><?=Yii::$app->formatter->asDate($model->creado)?> a las <?=Yii::$app->formatter->asTime($model->creado)?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /PAGE HEADER -->
</header>
<!-- /HEADER -->

<!-- section -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-8">

                <!-- post content -->
                <div class="section-row">
                    <?=$model->contenido ?>
                </div>
                <!-- /post content -->

                <!-- post tags -->
                <div class="section-row">
                    <div class="post-tags">
                        <ul>
                            <li>TAGS:</li>
                            <li><a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $model->categoria, "numArticulos"=>1]) ?>"><?=$model->categoria?></a></li>
                    </div>
                </div>
                <!-- /post tags -->

                <!-- /related post -->
                <div>
                    <div class="section-title">
                        <h3 class="title">Artículos relacionados</h3>
                    </div>
                    <div class="row">
                        <!-- post -->
                        <?php $artiRel = array_slice((array) $articulosRelacionados, 0,6);?>
                        <?php foreach($artiRel as $row): ?>
                            <!-- post categorias-->
                            <div class="col-md-4">
                                <div class="post post-sm">
                                    <a class="post-img" href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo])?>"><img src=<?=$img.$row->imagen ?> width="193.33" height="126"  alt="post_relacionados"></a>
                                    <div class="post-body">
                                        <div class="post-category">
                                            <a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $row->categoria , "numArticulos"=>1 ]) ?>"><?=$row->categoria?></a>
                                        </div>
                                        <h3 class="post-title title-sm"><a href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo])?>"><?=$row->titulo?></a></h3>
                                        <ul class="post-meta">
                                            <li><a href="author.html"><?=$row->autor ?></a></li>
                                            <li><?=Yii::$app->formatter->asDate($row->creado)?> a las <?=Yii::$app->formatter->asTime($row->creado)?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <!-- /post -->
                    </div>
                </div>
                <!-- /related post -->
                <!-- post reply -->
                <div class="section-row">
                    <div class="section-title">
                        <h3 class="title">Deja un comentario:</h3>
                    </div>
                    <?php Pjax::begin(['id'=>'id-pjax', 'enablePushState' => false]); ?>
                    <?= $form =Html::beginForm(["comentario/create"], 'post', ['data-pjax' => "", 'class' => 'form-inline']); ?>
                    <div class="col-md-12">
                        <?= Html::hiddenInput('id_articulo', $model->id_articulo)?>
                        <?= Html::hiddenInput('id_user', $user)?>
                        <?= Html::textarea('contenido_comentario')?>
                    </div>
                    <?= \himiklab\yii2\recaptcha\ReCaptcha2::widget([
                        'name' => 'reCaptcha',
                        'siteKey' => '6LcFb-0UAAAAAF8g1oB-SUjQ1HxndKtxdcWRQ8_p', // unnecessary is reCaptcha component was set up
                        'widgetOptions' => ['class' => 'col-md-12'],
                    ]) ?>
                    <div class="col-md-12">
                        <?php
                        if($user!=null) {
                            echo '<br><button type="submit" class="btn btn-primary"> Enviar</button>';

                        }else {
                            echo '<br><button type="submit" class="btn btn-primary" disabled>Bloquedo</button></p>Es necesario estar registrado para poder comentar.</p>';
                        }
                        ?>
                    </div>

                    <?= Html::endForm() ?>
                    <br>
                    <h3 id="success" class="d-none">Comentario enviado con éxito, pendiente de ser validado.</h3>
                    <h3 id="fail" class="d-none">Hubo un error al enviar el comentario, pruebe más tarde.</h3>
                    <?php Pjax::end(); ?>
                </div>
                <!-- /post reply -->
                <!-- post comments -->
                <div class="section-row">
                    <div class="section-title">
                        <h3 class="title">Comentarios</h3>
                    </div>
                    <div class="post-comments">
                        <?php foreach($comentarios as $comentario): ?>
                            <?php if($comentario->verificado){ ?>
                                <!-- comment -->
                                <div class="media">
                                    <div class="media-left">
                                        <img class="media-object"  src="http://placehold.it/50x50" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading">
                                            <?=User::findIdentity(($comentario->getIdUser()))->username ?>
                                            <span class="time"><?=Yii::$app->formatter->asDate($comentario->creado)?> a las <?=Yii::$app->formatter->asTime($comentario->creado)?></span>
                                        </div>
                                        <p><?=$comentario->getConenido() ?></p>
                                        <a href="#" class="reply">Responder</a>
                                    </div>
                                </div>
                            <?php } endforeach ?>
                        <!-- /comment -->
                    </div>
                </div>
                <!-- /post comments -->

            </div>
            <div class="col-md-4">
                <!-- Widget foto publicitaria -->
                <div class="aside-widget text-center">
                    <a href="#" style="display: inline-block;margin: auto;">
                        <img src="https://dummyimage.com/600x400/000/fff" alt="placeholder image" class="img-fluid" />
                    </a>
                </div>
                <!-- /Widget foto publicitaria -->

                <!-- social widget -->
                <div class="aside-widget">
                    <div class="section-title">
                        <h2 class="title">Social Media</h2>
                    </div>
                    <div class="social-widget">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/recordgo" class="social-facebook">
                                    <i class="fa fa-facebook"></i>
                                    <span>8.7K <br>Seguidores</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/recordgo" class="social-twitter">
                                    <i class="fa fa-twitter"></i>
                                    <span>2.2K<br>Seguidores</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="social-google-plus">
                                    <i class="fa fa-pinterest"></i>
                                    <span>22.6K<br>Visitantes/mes</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /social widget -->

                <!-- category widget -->
                <div class="aside-widget">
                    <div class="section-title">
                        <h2 class="title">Categorías</h2>
                    </div>
                    <div class="category-widget">
                        <ul>
                            <li><a href="http://backend.test/articulo/index">Todos <span><?=$cantidadArticulos?></span></a></li>
                            <?php foreach($categorias as $nombreCategoria => $cantidad){?>
                                <li><a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $nombreCategoria,"numArticulos"=>1]) ?>"><?=$nombreCategoria?> <span><?= $cantidad ?> </span></a></li>
                            <?php }  ?>
                        </ul>
                    </div>
                </div>
                <!-- /category widget -->

                <!-- post widget -->
                <div class="aside-widget">
                    <div class="section-title">
                        <h2 class="title">Articulos populares</h2>
                    </div>
                    <?php
                    $ultimosArticulosPopulares = array_slice((array) $articulosPopulares, 0,10);// límite de populares.
                    ?>
                    <?php foreach($ultimosArticulosPopulares as $row):?>
                        <!-- post -->
                        <div class="post post-widget">
                            <a class="post-img" href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo]) ?>"><img src=<?=$img.$row->imagen ?> alt=""></a>
                            <div class="post-body">
                                <div class="post-category">
                                    <a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $row->categoria,  "numArticulos"=>1 ]) ?>"><?=$row->categoria?></a>
                                </div>
                                <h3 class="post-title"><a href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo])?>"><?=$row->titulo?></a></h3>
                            </div>
                        </div>
                        <!-- /post -->
                    <?php endforeach ?>
                </div>
                <!-- /post widget -->

                <!-- galery widget -->
                <div class="aside-widget">
                    <div class="section-title">
                        <h2 class="title">Facebook</h2>
                    </div>
                    <div class="galery-widget">
                        <ul>
                            <li><a href="#"><img src="https://scontent.fmad8-1.fna.fbcdn.net/v/t1.0-9/p960x960/93500803_10158489406249994_1237092680240988160_o.jpg?_nc_cat=100&_nc_sid=8024bb&_nc_ohc=xNxyhRlml3MAX8nneke&_nc_ht=scontent.fmad8-1.fna&_nc_tp=6&oh=4aa1830170498d2600d7be5f2c5caa24&oe=5EEB76CB" alt=""></a></li>
                            <li><a href="#"><img src="https://scontent.fmad8-1.fna.fbcdn.net/v/t1.0-9/p960x960/88020375_10158314302544994_3574751140736139264_o.jpg?_nc_cat=109&_nc_sid=8024bb&_nc_ohc=Q-TwH9k7vI4AX92Enqw&_nc_ht=scontent.fmad8-1.fna&_nc_tp=6&oh=0b01424614782e95018eb0ce845e4ce2&oe=5EEBB351" alt=""></a></li>
                            <li><a href="#"><img src="https://scontent.fmad8-1.fna.fbcdn.net/v/t1.0-9/p960x960/89653297_10158355432069994_1427980216789106688_o.jpg?_nc_cat=110&_nc_sid=8024bb&_nc_ohc=CfmfkTMgrdEAX9X2Fcu&_nc_ht=scontent.fmad8-1.fna&_nc_tp=6&oh=a5df1aa6efca971ece98a51d744a0620&oe=5EEBAF1A" alt=""></a></li>
                            <li><a href="#"><img src="https://scontent.fmad8-1.fna.fbcdn.net/v/t1.0-9/p960x960/89597235_10158346036549994_8307128785312940032_o.jpg?_nc_cat=108&_nc_sid=8024bb&_nc_ohc=_m9Ne6FYWPEAX-EXu4R&_nc_ht=scontent.fmad8-1.fna&_nc_tp=6&oh=5f2de56961e1b70e4a15854145c27d7d&oe=5EED796A" alt=""></a></li>
                            <li><a href="https://www.facebook.com/recordgo/photos/a.10151346727574994/10158237059034994/?type=3&theater"><img src="https://scontent.fmad8-1.fna.fbcdn.net/v/t1.0-9/p960x960/84331635_10158237059039994_6619576838396051456_o.png?_nc_cat=105&_nc_sid=8024bb&_nc_ohc=wkVZ12gHKsoAX-ylmuu&_nc_ht=scontent.fmad8-1.fna&oh=47ebef11494169b0d11e2eaac13a04c2&oe=5EEF1089" alt=""></a></li>
                            <li><a href="#"><img src="./img/galery-6.jpg" alt=""></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /galery widget -->
                <!-- Ad widget -->
                <div class="aside-widget text-center">
                    <a href="#" style="display: inline-block;margin: auto;">
                        <img class="img-responsive" src="./img/ad-1.jpg" alt="">
                    </a>
                </div>
                <!-- /Ad widget -->
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->
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