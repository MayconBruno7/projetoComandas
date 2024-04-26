<?php

    require_once "helpers/protectUser.php";    

    // carrega a classe do banco de dados
    require_once "library/Database.php";
    // atribui a conexão a variável $db
    $db = new Database();
    // tenta fazer a conexão com banco de dados
    try {
        // atribui o resultado do dbDelete a variavel $result
        $result = $db->dbDelete("DELETE FROM comanda 
                                WHERE ID_COMANDA = ?",
                                [$_POST['idComanda']]
                            );

        // verifica se a váriavel $result é true
        if ($result) {
            return header("Location: listaComanda.php?msgSucesso=Comanda excluída.");
        } else {
            return header("Location: listaComanda.php?msgError=Falha ao tentar excluír a comanda.");
        }
    // se ocorrer um erro de conexão é retornado pelo bloco catch
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }