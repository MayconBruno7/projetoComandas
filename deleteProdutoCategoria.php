<?php
require_once "helpers/protectNivel.php";
require_once "library/Database.php";

$db = new Database();

    try {
        $result = $db->dbDelete("DELETE FROM produto_categoria WHERE ID_CATEGORIA = ?", [$_POST['ID_CATEGORIA']]);


        if ($result) {
            return header("Location: listaProdutoCategoria.php?msgSucesso=Registro excluído com sucesso.");

        } else {
            return header("Location: listaProdutoCategoria.php?msgError=Falha ao tentar excluir o registro.");
        }


    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
}