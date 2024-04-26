<?php

    require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    $db = new Database();

    try {
        $result = $db->dbUpdate("UPDATE produto_categoria 
                                SET DESCRICAO_CATEGORIA = ?, TIPO_CATEGORIA = ?, STATUS_CATEGORIA = ?
                                WHERE ID_CATEGORIA = ?",
                                [
                                    $_POST['DESCRICAO_CATEGORIA'],
                                    $_POST['TIPO_CATEGORIA'],
                                    $_POST['STATUS_CATEGORIA'],
                                    $_POST['ID_CATEGORIA']
                                ]);

        if ($result) {
            return header("Location: listaProdutoCategoria.php?msgSucesso=Registro alterado com sucesso.");
        } else {
            return header("Location: listaProdutoCategoria.php?msgError=Falha ao tentar alterar o registro.");
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }