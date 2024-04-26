<?php

    require_once "helpers/protectNivel.php";

    // carrega o banco de dados
    require_once "library/Database.php";

    // atribui a conexão a $db
    $db = new Database();

    try {
        // executa a query de insert no banco de dados 
        $result = $db->dbInsert("INSERT INTO formas_pagamento 
                                (DESCRICAO_FORMA_PAGAMENTO, SITUACAO_FORMA_PAGAMENTO)
                                VALUES (?, ?)",
                                [
                                    $_POST['descricao'],
                                    $_POST['statusCadastro']
                                ]);

        // verifica se o $result retornou verdadeiro
        if ($result) {
            return header("Location: listaFormaPagamento.php?msgSucesso=Registro inserido com sucesso.");
        } else {
            return header("Location: listaFormaPagamento.php?msgError=Falha ao tentar inserir o registro.");
        }
        
    // se houver um erro na conexão com o banco de dados é retornado pelo bloco catch
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }