<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Blog';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">>

    <!-- Bootstrap core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


</head>

<body>

<!-- Page Content -->
<div class="container-fluid">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="my-4">Page Heading
                <small>Secondary Text</small>
            </h1>
            <!-- Blog Post -->
            <?php foreach($model as $row): ?>
            <tr>
                <div class="card mb-4">
                    <img class="card-img-top" src=/<?= $row->imagen ?> alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title"><?= $row->titulo ?></h2>
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
                        <a class="btn btn-primary" href="<?= Url::toRoute(["articulo/post/", "id_articulo"=> $row->id_articulo]) ?>">Leer más &rarr;</a>
                    </div>
                    <div class="card-footer text-muted">Publicado en <?=Yii::$app->formatter->asDate($row->creado)?> a las <?=Yii::$app->formatter->asTime($row->creado)?>
                    </div>
                </div>
                <?php endforeach ?>
                <!-- Pagination -->
                <ul class="pagination justify-content-center mb-4">
                    <li class="page-item">
                        <a class="page-link" href="#">&larr; Older</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Newer &rarr;</a>
                    </li>
                </ul>

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Search Widget -->
            <div class="card my-4">
                <h5 class="card-header">Search</h5>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
                    </div>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">Categorías</h5>
                <div class="card-body" position="fixed">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="http://backend.local:8080/index.php/articulo/index">All</a></li>
                                <?php foreach($categorias as $categoria):?>
                                    <li><a href="<?= Url::toRoute(["articulo/category/", "categoria"=> $categoria]) ?>"><?=$categoria?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <!-- otra lista Widget -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Widget -->
            <div class="card my-4">
                <h5 class="card-header">Side Widget</h5>
                <div class="card-body">
                    You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
                </div>
            </div>

        </div>

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
    </div>
    <!-- /.container -->
</footer>
</body>

</html>
