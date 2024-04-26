<?php

    require_once "helpers/protectNivel.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    if (isset($_POST['descricao'])) {

        $db = new Database();

        try {

            $result = $db->dbInsert("INSERT INTO mesas
                                    (DESCRICAO_MESA)
                                    VALUES (?)",
                                    [
                                        $_POST['descricao'],
                                    ]);

            if ($result) {
                return header("Location: listaMesa.php?msgSucesso=Registro inserido com sucesso.");
            } else {
                return header("Location: listaMesa.php?msgError=Falha ao tentar inserir o registro.");
            }
                
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }
        
    } else {
        return header("Location: listaMesa.php");
    }