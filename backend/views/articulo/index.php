<?php
use yii\helpers\Url;

/* @var $this yii\web\View */

$img = Url::to('@web/uploads/');
$this->title = 'Blog';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
</head>

<body>
<!--    </div>-->
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

<!-- SECCIÓN POPULARES -->
<div class="section">
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
            '<div class="post post-thumb">
                <a class="post-img" href='.Url::toRoute(["articulo/post", "id_articulo"=>$populares[$i]->id_articulo]).'><img src='.$img.$populares[$i]->imagen.' alt=""></a>
                <div class="post-body">
                    <div class="post-category">
                        <a href='.Url::toRoute(["articulo/category/", "categoria"=> $populares[$i]->categoria]).'>'.$populares[$i]->categoria.'</a>
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
                        $model2 = array_slice((array)$model, 0,4);
                     ?>
                    <?php foreach($model2 as $row): ?>
                    <div class="col-md-6">
                        <div class="post">
                            <a class="post-img" href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo]) ?>"><img src=<?=$img.$row->imagen ?> alt=""></a>
                            <div class="post-body">
                                <div class="post-category">
                                    <a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $row->categoria])?>"><?=$row->categoria ?></a>
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

                <!-- row -->
                <?php foreach ($articulosPorCategorias as $nombreCategoria => $articulos) {?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2 class="title"><?=$nombreCategoria?></h2>
                            </div>
                        </div>
                <?php $model3 = array_slice((array) $articulos, 0,3);?>
                    <?php foreach($model3 as $row): ?>
                    <!-- post -->
                    <div class="col-md-4">
                        <div class="post post-sm">
                            <a class="post-img" href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo])?>"><img src=<?=$img.$row->imagen ?> alt=""></a>
                            <div class="post-body">
                                <div class="post-category">
                                    <a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $row->categoria ]) ?>"><?=$row->categoria?></a>
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
                <!-- /row -->
                <?php  }?>

            </div>
            <div class="col-md-4">
                <!-- ad widget-->
                <div class="aside-widget text-center">
                    <a href="#" style="display: inline-block;margin: auto;">
                        <img class="img-responsive" src="../../web/img/ad-3.jpg" alt="">
                    </a>
                </div>
                <!-- /ad widget -->

                <!-- social widget -->
                <div class="aside-widget">
                    <div class="section-title">
                        <h2 class="title">Social Media</h2>
                    </div>
                    <div class="social-widget">
                        <ul>
                            <li>
                                <a href="#" class="social-facebook">
                                    <i class="fa fa-facebook"></i>
                                    <span>21.2K<br>Followers</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="social-twitter">
                                    <i class="fa fa-twitter"></i>
                                    <span>10.2K<br>Followers</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="social-google-plus">
                                    <i class="fa fa-google-plus"></i>
                                    <span>5K<br>Followers</span>
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
                            <li><a href="http://backend.test/articulo/prueba">Todos <span><?=$cantidadArticulos?></span></a></li>
                            <?php foreach($categorias as $nombreCategoria => $cantidad){?>
                                <li><a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $nombreCategoria]) ?>"><?=$nombreCategoria?> <span><?= $cantidad ?> </span></a></li>
                            <?php }  ?>
                        </ul>
                    </div>
                </div>
                <!-- /category widget -->

                <!-- newsletter widget -->
                <div class="aside-widget">
                    <div class="section-title">
                        <h2 class="title">Newsletter</h2>
                    </div>
                    <div class="newsletter-widget">
                        <form>
                            <p>Nec feugiat nisl pretium fusce id velit ut tortor pretium.</p>
                            <input class="input" name="newsletter" placeholder="Enter Your Email">
                            <button class="primary-button">Subscribe</button>
                        </form>
                    </div>
                </div>
                <!-- /newsletter widget -->

                <!-- widget resto populares-->
                <div class="aside-widget">
                    <div class="section-title">
                        <h2 class="title">Articulos populares</h2>
                    </div>
                    <?php
                    $restoPopulares = array_slice((array) $articulosPopulares, 3,sizeof($articulosPopulares));// límite de populares.
                    ?>
                    <?php foreach($restoPopulares as $row):?>
                    <!-- post -->
                    <div class="post post-widget">
                        <a class="post-img" href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo]) ?>"><img src=<?=$img.$row->imagen ?> alt=""></a>
                        <div class="post-body">
                            <div class="post-category">
                                <a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $row->categoria ]) ?>"><?=$row->categoria?></a>
                            </div>
                            <h3 class="post-title"><a href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo])?>"><?=$row->titulo?></a></h3>
                        </div>
                    </div>
                    <!-- /post -->
                    <?php endforeach ?>
                </div>
                <!-- /widget resto populares-->
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
                    <img class="img-responsive" src="./img/ad-2.jpg" alt="">
                </a>
            </div>
            <!-- /ad -->
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
            <div class="col-md-8">
                <?php
                $model3 = array_slice((array) $model, 4,sizeof($model));// resto de articulos
                ?>
                <?php foreach($model3 as $row): ?>
                <!-- post -->
                <div class="post post-row">
                    <a class="post-img" href="<?= Url::toRoute(["articulo/post", "id_articulo"=>$row->id_articulo]) ?>"><img src=<?=$img.$row->imagen ?> alt=""></a>
                    <div class="post-body">
                        <div class="post-category">
                            <a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $row->categoria ]) ?>"><?=$row->categoria?></a>
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
                    <a href="#" class="primary-button">Load More</a>
                </div>
            </div>
            <div class="col-md-4">
                <!-- galery widget -->
                <div class="aside-widget">
                    <div class="section-title">
                        <h2 class="title">Instagram</h2>
                    </div>
                    <div class="galery-widget">
                        <ul>
                            <li><a href="#"><img src="./img/galery-1.jpg" alt=""></a></li>
                            <li><a href="#"><img src="./img/galery-2.jpg" alt=""></a></li>
                            <li><a href="#"><img src="./img/galery-3.jpg" alt=""></a></li>
                            <li><a href="#"><img src="./img/galery-4.jpg" alt=""></a></li>
                            <li><a href="#"><img src="./img/galery-5.jpg" alt=""></a></li>
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