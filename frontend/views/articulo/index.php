<?php

use frontend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

function compararObjetos($obj_a, $obj_b) {
    return $obj_a->id - $obj_b->id;
}
$backend = BackendAsset::register($this);
/* @var $this yii\web\View */
$img = Url::to('@web/assets/d086a17a/');
$id = (Yii::$app->user->identity);
$user=\common\models\User::findIdentity($id);
if($user !=null){
$user= $user->getId();
}
$notification= \dvamigos\Yii2\Notifications\Notification::findIdentity($id);
$this->title = 'Blog';
?>
<!DOCTYPE html>
<html lang="es">
<body>

<!-- SECCIÓN POPULARES -->
<div class="section" style=" margin-top:-70px;">
    <!-- container -->
    <div class="container">
        <div class="section-title">
            <h2 class="title">Publicaciones populares</h2>
        </div>
        <?php
        $populares = array_slice((array) $articulosPopulares, 0,3);// límite de populares.
        ?>
        <?php
        echo
            //<!-- row -->
        '<div id="hot-post" class="row hot-post">';
        for($i=0; $i < count($populares); $i++){
            if($i==0 && sizeof($populares)>1 ){ //El más reciente de los populares, en grande
                echo
                '<div class="col-md-8 hot-post-left">';
            }
            if($i==0 && sizeof($populares)==1 ){ //Solo hay un popular
                echo
                '<div class="col-md-10 hot-post-left">';
            }
            if($i==1){
                echo
                '<div class="col-md-4 hot-post-right">'; //Los siguientes populares (hasta 3)
            }
            echo // información de los articulos
            '<div class="post post-thumb">';
            if($i==0){
                echo '<a class="post-img" href='.Url::toRoute(["articulo/post", "id_articulo"=>$populares[$i]->id_articulo]).'><img src='.$img.$populares[$i]->imagen.' width="300" height="450" alt="imagenes_populares"></a>';
            }else{
                echo '<a class="post-img" href='.Url::toRoute(["articulo/post", "id_articulo"=>$populares[$i]->id_articulo]).'><img src='.$img.$populares[$i]->imagen.' width="300" height="222" alt="imagenes_populares"></a>';}
            echo
                '<div class="post-body">
                    <div class="post-category">
                        <a href='.Url::toRoute(["articulo/category/", "categoria"=> $populares[$i]->categoria, "numArticulos"=>1]).'>'.$populares[$i]->categoria.'</a>
                    </div>
                    <h3 class="post-title title-lg"><a href='.Url::toRoute(["articulo/post", "id_articulo"=>$populares[$i]->id_articulo]).'> '.$populares[$i]->titulo.' </a></h3>
                    <ul class="post-meta">
                        <li><a href="author.html">'.$populares[$i]->autor.'</a></li>
                        <li>'.Yii::$app->formatter->asDate($populares[$i]->creado)?> a las <?=Yii::$app->formatter->asTime($populares[$i]->creado).'</li>
                    </ul>
                </div>
            </div>';
            if($i==0){
                echo '</div>';
            }
        }echo'
            </div>
        </div>';
        ?>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECCIÓN POPULARES -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-8">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2 class="title">Publicaciones recientes</h2>
                        </div>
                    </div>
                    <!-- post -->
                    <?php
                    $resultado = array_udiff($model, $populares, 'compararObjetos');
                    $model2 = array_slice((array)$resultado, 0,4);
                    ?>
                    <?php foreach($model2 as $row): ?>
                        <div class="col-md-6">
                            <div class="post">
                                <a class="post-img" href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo]) ?>"><img src="<?=$img.$row->imagen ?>" width="300" height="200"alt="fotos_recientes"></a>
                                <div class="post-body">
                                    <div class="post-category">
                                        <a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $row->categoria, "numArticulos"=>1])?>"><?=$row->categoria ?></a>
                                    </div>
                                    <h3 class="post-title"><a href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo])?>"><?=$row->titulo ?></a></h3>
                                    <?php
                                    //limpiar código html
                                    $textoPlano = strip_tags($row->contenido);
                                    //acortar texto
                                    if(strlen($textoPlano) >= 200){
                                        $resumen = substr($textoPlano,0,strrpos(substr($textoPlano,0,200)," "))."...";
                                    }else{
                                        $resumen = $textoPlano;
                                    }
                                    ?>
                                    <p class="card-text"><?= $resumen?></p>
                                    <ul class="post-meta">
                                        <li><a href="author.html"><?=$row->autor ?></a></li>
                                        <li><?=Yii::$app->formatter->asDate($row->creado)?> a las <?=Yii::$app->formatter->asTime($row->creado)?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <!-- /post -->
                    <div class="clearfix visible-md visible-lg"></div>
                </div>
                <!-- /row -->

                <!-- row titulo categoria-->
                <?php foreach ($articulosPorCategorias as $nombreCategoria => $articulos) {?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2 class="title"><?=$nombreCategoria?></h2>
                            </div>
                        </div>
                        <?php $model3 = array_slice((array) $articulos, 0,3);?>
                        <?php foreach($model3 as $row): ?>
                            <!-- post categorias-->
                            <div class="col-md-4">
                                <div class="post post-sm">
                                    <a class="post-img" href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo])?>"><img src=<?=$img.$row->imagen ?> width="193.33" height="126"  alt="fotos_categoria"></a>
                                    <div class="post-body">
                                        <div class="post-category">
                                            <a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $row->categoria , "numArticulos"=>1]) ?>"><?=$row->categoria?></a>
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
                        <!-- /post categorias -->
                    </div>
                    <!-- /row titulo categoria-->
                <?php  }?>
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
                                <li><a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $nombreCategoria,  "numArticulos"=>1]) ?>"><?=$nombreCategoria?> <span><?= $cantidad ?> </span></a></li>
                            <?php }  ?>
                        </ul>
                    </div>
                </div>
                <!-- /category widget -->

                <!-- Suscripcion widget -->
                <div class="aside-widget">
                    <div class="section-title">
                        <h2 class="title">Recibir notificaciones:</h2>
                    </div>
                    <div class="newsletter-widget">
                        <?php Pjax::begin(['id'=>'notificacion','enablePushState' => false]); ?>
                        <?php if($notification == null){ ?>
                            <?= $form =Html::beginForm(["articulo/notification"], 'post', ['data-pjax' => "", 'class' => 'form-inline']); ?>
                            <p>Subscríbete para recibir notificaciones con las últimas noticias.</p>
                            <?= Html::hiddenInput('id_user', $user)?>
                            <button class="primary-button">Subscribirse</button>
                            <?= Html::endForm() ?>

                        <?php }else{ ?>
                            <?= $form =Html::beginForm(["articulo/removenotification"], 'post', ['data-pjax' => "", 'class' => 'form-inline']); ?>
                            <p>Desuscribirse para no recibir más notificaciones.</p>
                            <?= Html::hiddenInput('id_user', $user)?>
                            <button class="primary-button">Desuscribirse</button>
                            <?= Html::endForm() ?>

                        <?php } ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
                <!-- /Suscripcion widget -->

                <!-- widget resto populares-->
                <div class="aside-widget">
                    <div class="section-title">
                        <h2 class="title">Articulos populares</h2>
                    </div>
                    <?php
                    $restoPopulares = array_slice((array) $articulosPopulares, 3, 4);// sizeof($articulosPopulares) --> si quieres el límite sea populares.
                    ?>
                    <?php foreach($restoPopulares as $row):?>
                        <!-- post -->
                        <div class="post post-widget">
                            <a class="post-img" href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo]) ?>"><img src=<?=$img.$row->imagen ?> width="130" height="86.7" alt="resto_populares"></a>
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
                <!-- /widget resto populares-->
                <!-- Ad widget -->
                <div class="aside-widget text-left">
                    <a href="#" style="display: inline-block;margin: auto;">
                        <img src="https://dummyimage.com/300x450/000/fff" alt="placeholder image" class="img-fluid" />
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
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- ad -->
            <div class="col-md-12 section-row text-center">
                <a href="#" style="display: inline-block;margin: auto;">
                    <img src="https://dummyimage.com/720x90/000/fff" alt="placeholder image" class="img-fluid" />
                </a>
            </div>
            <!-- /ad -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- Resto de articulos -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-8">
                <?php Pjax::begin(); ?>
                <?php
                $model3 = array_slice((array) $model, 4, $numArticulos);// resto de articulos
                ?>
                <?php foreach($model3 as $row): ?>
                    <!-- post -->
                    <div class="post post-row">
                        <a class="post-img" href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo]) ?>"><img src=<?=$img.$row->imagen ?> width="247.98" height="165.39"  alt="resto_articulos"></a>
                        <div class="post-body">
                            <div class="post-category">
                                <a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $row->categoria ,"numArticulos"=>1]) ?>"><?=$row->categoria?></a>
                            </div>
                            <h3 class="post-title"><a href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo])?>"><?=$row->titulo?></a></h3></h3>
                            <ul class="post-meta">
                                <li><a href="author.html"><?=$row->autor ?></a></li>
                                <li><?=Yii::$app->formatter->asDate($row->creado)?> a las <?=Yii::$app->formatter->asTime($row->creado)?></li>
                            </ul>
                            <?php
                            //limpiar código html
                            $textoPlano = strip_tags($row->contenido);
                            //acortar texto
                            if(strlen($textoPlano) >= 200){
                                $resumen = substr($textoPlano,0,strrpos(substr($textoPlano,0,200)," "))."...";
                            }else{
                                $resumen = $textoPlano;
                            }
                            ?>
                            <p class="card-text"><?= $resumen?></p>
                        </div>
                    </div>
                    <!-- /post -->
                <?php endforeach ?>
                <div class="section-row loadmore text-center">
                    <?php if($numArticulos+1 > sizeof($model)-4 || $numArticulos+1 == sizeof($model)-4){
                        echo "<p></p>";
                    }else{
                        echo Html::a("Cargar Más", ['articulo/index','numArticulos' => $numArticulos+1], ['class' => 'btn btn-lg primary-button']);}
                    ?>
                </div>
            </div>
            <div class="col-md-4">
                <?php Pjax::end(); ?>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /FIN resto de articulos -->
</body>
<script>
    $("#my_tab_id").click(function() {
        $.pjax.reload({container: '#notification', async: false});
    });
</script>