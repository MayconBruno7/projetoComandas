<?php

    require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    $db = new Database();

    try {
        $result = $db->dbUpdate("UPDATE formas_pagamento
                                SET DESCRICAO_FORMA_PAGAMENTO = ?, SITUACAO_FORMA_PAGAMENTO = ?
                                WHERE ID_FORMA_PAGAMENTO = ?",
                                [
                                    $_POST['descricao'],
                                    $_POST['statusCadastro'],
                                    $_POST['id']
                                ]);

        if ($result) {
            return header("Location: listaFormaPagamento.php?msgSucesso=Registro alterado com sucesso.");
        } else {
            return header("Location: listaFormaPagamento.php?msgError=Falha ao tentar alterar o registro.");
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }