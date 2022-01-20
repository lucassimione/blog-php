<?php
include './../app/Libraries/Routes.php'; 
include './../app/Libraries/Controller.php'; 
include './../app/configuracao.php';
include './../app/Libraries/Database.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=APP_NOME?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=URL . '/public/css/estilos.css';?>" rel="stylesheet">
</head>
<body>
    <?php 
    include APP . '/Views/cabecalho.php';
    $db = new app\Libraries\Database();
    $rotas = new app\Libraries\Routes(); 
    include APP . '/Views/rodape.php';
    $db -> query("SELECT * FROM post");
    //$db -> resultado();
    //echo $db -> resultado() -> titulo;

    foreach($db->resultados() as $post)
    {
        echo $post-> titulo . '<br>';
    }

    echo '<hr> Total resultados' . $db->totalResultados();
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="<?=URL . '/public/js/jquery.funcoes.js';?>"></script>
</html>