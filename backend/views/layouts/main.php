<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <!--    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>-->

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CMuli:400,700" rel="stylesheet">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() //'brandLabel' => Yii::$app->name,?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Blog', 'url' => ['articulo/index']],
        ['label' => 'Lista de categorias', 'url' => ['categoria/index']],
        ['label' => 'Lista de articulos', 'url' => ['articulo/articulos']],
        ['label' => 'Lista de comentarios', 'url' => ['comentario/index']],
        ['label' => 'Lista de usuarios', 'url' => ['user/usuarios']],
        ['label' => 'Crear Articulo', 'url' => ['articulo/create']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-expand-md'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    //<--- fin navbar---->
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content?>
    </div>
</div>
<!-- footer -->

<footer class="page-footer bg-dark font-small mdb-color pt-4">
    <section class="links">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="accordion">
                        <h4 class="accordion-header">Legal<i class="icon-flecha-abajo pull-right"></i></h4>
                        <div class="accordion-content" style="display: none;">
                            <ul>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/recordgo-condiciones/" title="Términos y condiciones generales - Record go rent a car">Términos y condiciones generales</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/privacity/" title="Política de Privacidad y Protección de datos - Record go rent a car">Política de Privacidad y Protección de datos</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/cookies/" title="Privacidad y Cookies - Record go rent a car">Cookies</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/use-conditions/" title="Aviso Legal - Record go rent a car">Aviso legal</a>
                                </li>
                            </ul>                            </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="accordion">
                        <h4 class="accordion-header">Alquiler de coches<i class="icon-flecha-abajo pull-right"></i></h4>
                        <div class="accordion-content" style="display: none;">
                            <ul>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-mallorca-aeropuerto/" title="Alquiler de coches en Mallorca Aeropuerto - Record Go"><span class="icon-icon-plane"></span> Mallorca Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-malaga-aeropuerto/" title="Alquiler de coches en Málaga Aeropuerto - Record Go"><span class="icon-icon-plane"></span> Málaga Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-alicante-aeropuerto/" title="Alquiler de coches en Alicante Aeropuerto - Record Go"><span class="icon-icon-plane"></span> Alicante Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-ibiza-aeropuerto/" title="Alquiler de coches en Ibiza Aeropuerto - Record Go"><span class="icon-icon-plane"></span> Ibiza Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-barcelona-sants/" title="Alquiler de coches en Barcelona Sants - Record Go"><span class="icon-icon-plane"></span> Barcelona Sants</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-barcelona-aeropuerto/" title="Alquiler de coches en Barcelona Aeropuerto - Record Go"><span class="icon-icon-plane"></span> Barcelona Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-bilbao-aeropuerto/" title="Alquiler de coches en Bilbao Aeropuerto - Record Go"><span class="icon-icon-plane"></span> Bilbao Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-sevilla-aeropuerto/" title="Alquiler de coches en Sevilla - Record Go"><span class="icon-icon-plane"></span> Sevilla Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-valencia-aeropuerto/" title="Alquiler de coches en Valencia - Record Go"><span class="icon-icon-plane"></span> Valencia Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-madrid-aeropuerto/" title="Alquiler de coches en Madrid Aeropuerto - Record Go"><span class="icon-icon-plane"></span> Madrid Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-madrid-atocha/" title="Alquiler de coches en Madrid Atocha- Record Go"><span class="icon-icon-plane"></span> Madrid Atocha</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-menorca-aeropuerto/" title="Alquiler de coches en Menorca Aeropuerto - Record Go"><span class="icon-icon-plane"></span> Menorca Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-lisboa-aeropuerto/" title="Alquiler de coches en Lisboa Aeropuerto - Record Go"><span class="icon-icon-plane"></span> Lisboa Aeropuerto</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/alquiler-coches-oporto-aeropuerto/" title="Alquiler de coches en Oporto Aeropuerto - Record Go"><span class="icon-icon-plane"></span> Oporto Aeropuerto</a>
                                </li>
                            </ul>                            </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="accordion">
                        <h4 class="accordion-header">Productos y servicios<i class="icon-flecha-abajo pull-right"></i></h4>
                        <div class="accordion-content" style="display: none;">
                            <ul>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/extras/cobertura-total-confort/" title="Cobertura Total Confort - Record go rent a car"><span></span> Cobertura Total Confort</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/extras/conductor-adicional/" title="Conductor adicional - Record go rent a car"><span></span> Conductor adicional</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/extras/gopad/" title="Dispositivo GoPad - Record go"><span></span> GoPad</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/extras/recogida-expres/" title="Recogida exprés - Record go rent a car"><span></span> Recogida Exprés</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/extras/tarifa-just-go/" title="Tarifa Just Go - Record go rent a car"><span></span>Tarifa Just Go</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/extras/sillas-infantiles/" title="Sillas infantiles – Record go rent a car"><span></span>Sillas infantiles</a>
                                </li>
                            </ul>                            </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="accordion">
                        <h4 class="accordion-header">Record go<i class="icon-flecha-abajo pull-right"></i></h4>
                        <div class="accordion-content" style="display: none;">
                            <ul>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/recordgo-aeropuertos-españa/" title="Quiénes somos - Record go rent a car">Quiénes Somos</a>
                                </li>
                                <li>
                                    <a href="https://www.recordgoocasion.es/" title="Vehiculos de ocasión - Record go Ocasión">Vehiculos de ocasión</a>
                                </li>
                                <li>
                                    <a href="https://jobs.recordrentacar.com/jobs" title="Trabaja con nosotros - Record go rent a car">Trabaja con nosotros</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/club-record-go/" title="Únete al Club Record go">Únete al Club Record go</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/recordgo-faqs/" title="Preguntas frecuentes - Record go rent a car">FAQs</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/recordgo-contacto/" title="Contacta con nosotros - Record go rent a car">Atención al cliente</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/es/recordgo-opiniones/" title="Opiniones alquiler de coches – Record go">Record go opiniones</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/blog/category/destinos/" title="Destinos turísticos – Record go" onclick="ga('send', 'event', 'InboundClicks', 'Footer', 'Blog');">Destinos turísticos</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/blog/category/alquiler-de-coches/" title="Consejos para alquiler de coches – Record go" onclick="ga('send', 'event', 'InboundClicks', 'Footer', 'Blog');">Consejos para alquiler de coches</a>
                                </li>
                                <li>
                                    <a href="https://www.recordrentacar.com/blog/category/viajar-en-coche/" title="Consejos para viajar en coche – Record go" onclick="ga('send', 'event', 'InboundClicks', 'Footer', 'Blog');">Consejos para viajar en coche</a>
                                </li>
                            </ul>                            </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left cards">
                        <img src="../layouts/icon-visa.png" alt="">
                        <img src="../layouts/icon-mastercard.png" alt="">
                        <img src="../layouts/icon-american.png" alt="">
                        <img src="../layouts/union-pay.png" alt="">
                        <img src="../layouts/electronic-cash.png" alt="">
                    </div>
                    <div class="pull-right trust">
                        <div class="globalSign">
                            <!--- DO NOT EDIT - GlobalSign SSL Site Seal Code - DO NOT EDIT --->
                            <table width="125" border="0" cellspacing="0" cellpadding="0" title="CLICK TO VERIFY: This site uses a GlobalSign SSL Certificate to secure your personal information.">
                                <tbody><tr>
                                    <td>
                                        <script src="//ssif1.globalsign.com/SiteSeal/siteSeal/siteSeal/siteSeal.do?p1=www.recordrentacar.com&amp;p2=SZ100-40&amp;p3=image&amp;p4=en&amp;p5=V0024&amp;p6=S001&amp;p7=https"></script><span><img name="ss_imgTag" border="0" src="//ssif1.globalsign.com/SiteSeal/siteSeal/siteSeal/siteSealImage.do?p1=www.recordrentacar.com&amp;p2=SZ100-40&amp;p3=image&amp;p4=en&amp;p5=V0024&amp;p6=S001&amp;p7=https&amp;deterDn=" alt="" oncontextmenu="return false;" galleryimg="no" style="width:100px"></span><span id="ss_siteSeal_fin_SZ100-40_image_en_V0024_S001"></span>
                                        <script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_100-40_en_white.js"></script>
                                    </td>
                                </tr>
                                </tbody></table>
                            <!--- DO NOT EDIT - GlobalSign SSL Site Seal Code - DO NOT EDIT --->
                        </div>


                        <a href="https://www.ekomi.es/testimonios-recordrentacarcom-es.html" target="_blank" rel="noopener">
                            <img src="../layouts/ekomi.png" alt="ekomi">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="rrss text-center">
        <a href="https://www.facebook.com/recordgo" target="_blank" rel="noopener">
            <i class="icon-facebook"></i>
        </a>
        <a href="https://twitter.com/recordgo" target="_blank" rel="noopener">
            <i class="icon-twitter"></i>
        </a>
        <a href="https://www.youtube.com/user/RecordGo" target="_blank" rel="noopener">
            <i class="icon-youtube"></i>
        </a>
        <a href="https://www.pinterest.es/recordgo/" target="_blank" rel="noopener">
            <i class="icon-pinterest"></i>
        </a>
    </section>
</footer>
<?php $this->endBody() ?>
</body>
<!-- jQuery Plugins -->
<script src="../../web/js/jquery.min.js"></script>
<script src="../../web/js/bootstrap.min.js"></script>


</html>
<?php $this->endPage() ?>
