<?php

    require_once "helpers/protectUser.php";
    require_once "library/Database.php";

    if (isset($_POST['MESA_ID_MESA'])) {

        $db = new Database();
        $criacao = date('Y-m-d H:i:s');

        try {

            $result = $db->dbInsert("INSERT INTO comanda
                                    (DESCRICAO_COMANDA, MESA_ID_MESA, DATA_ABERTURA)
                                    VALUES (?, ?, ?)",
                                    [
                                        $_POST['DESCRICAO_COMANDA'],
                                        $_POST['MESA_ID_MESA'],
                                        $criacao
                                    ]);

            if ($result) {
                return header("Location: listaComanda.php?msgSucesso=Registro inserido com sucesso.");
            } else {
                return header("Location: listaComanda.php?msgError=Falha ao tentar inserir o registro.");
            }
            
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }

    } else {
        return header("Location: index.php");
    }