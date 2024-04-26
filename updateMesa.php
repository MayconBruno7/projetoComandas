<?php

    require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    $db = new Database();

    try {

        $result = $db->dbUpdate("UPDATE mesas 
                                SET DESCRICAO_MESA = ? 
                                WHERE ID_MESA = ?",
                                [
                                    $_POST['descricao'],
                                    $_POST['id']
                                ]);

        if ($result) {
            return header("Location: listaMesa.php?msgSucesso=Registro alterado com sucesso.");
        } else {
            return header("Location: listaMesa.php?msgError=Falha ao tentar alterar o registro.");
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }