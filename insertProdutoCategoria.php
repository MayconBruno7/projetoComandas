<?php

    require_once "helpers/protectNivel.php";
    require_once "library/Database.php";

    $db = new Database();

    try {

        $result = $db->dbInsert("INSERT INTO produto_categoria 
        (DESCRICAO_CATEGORIA, TIPO_CATEGORIA, STATUS_CATEGORIA)
        VALUES (?, ?, ?)",
        [
            $_POST['DESCRICAO_CATEGORIA'],
            $_POST['TIPO_CATEGORIA'],
            $_POST['STATUS_CATEGORIA']
        ]);

        if ($result) {
            return header("Location: listaProdutoCategoria.php?msgSucesso=Registro inserido com sucesso.");
        } else {
            return header("Location: listaProdutoCategoria.php?msgError=Falha ao tentar inserir o registro.");
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }