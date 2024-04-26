<?php

// se a sessão não estiver sido iniciada inicia a sessão
if (!isset($_SESSION)) {
    session_start();
}

// carrega o formulário
require_once "helpers/Formulario.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Comandas</title>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="/css/estiloComanda.css">

    <script src="assets/js/jquery-3.3.1.js"></script>
    <!-- Sem esse cdn o dropdown na navBarCollapese não funciona -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <!-- Adiciona o bootstrap a página -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- Adiciona a biblioteca jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar bluenave align-items-center d-flex justify-content-beetwen">
        <a href="home.php"><img src="/img/logo.png" alt="Imagem logo" style="width: 120; height: 90px; padding: 10px; margin-right: 50px;"> </a>
        <a class="home navbar-brand text-light " title="Home" href="home.php"></a>
        <?php if (isset($_SESSION['userId']) && ($_SESSION['userNivel'] == 1)) : ?>
            <a class="nav-link active" aria-current="page" href="home.php">Inicio</a>
            <a class="nav-link active" aria-current="page" href="produtos.php">Produtos</a>
            <a class="nav-link active" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $_SESSION['userNome'] //. " " . getNivelDescricao($_SESSION['userNivel']) ?></a>
            <a href="logoff.php" class="no-underline">
                <input class="nav-link active " title="Sair" type="submit" value="Sair">
            </a>
        <?php elseif (!isset($_SESSION['userNome'])) : ?>

        <?php else : ?>
            <a class="nav-link active" aria-current="page" href="home.php">Inicio</a>
            <a class="nav-link active" aria-current="page" href="produtos.php">Produtos</a>
            <a class="nav-link active" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $_SESSION['userNome'] //. " " . getNivelDescricao($_SESSION['userNivel']) ?></a>
            <a href="logoff.php">
                <input class="nav-link active " title="Sair" type="submit" value="Sair">
            </a>
        <?php endif; ?>
    </nav>
    
</body>

</html>