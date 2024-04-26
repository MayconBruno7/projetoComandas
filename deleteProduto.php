<?php

    require_once "helpers/protectNivel.php";
    // carrega a classe do banco de dados
    require_once "library/Database.php";

    // atribui a conexão com o banco de dados a $db
    $db = new Database();

    // tenta a conexão
    try {
        // atribui a função dbDelete ao objeto resultante $result 
        $result = $db->dbDelete("DELETE FROM produto 
                                WHERE ID_PRODUTOS = ?",
                                [$_POST['id']]
                            );

        // verificar se o result existe
        if ($result) {

            // unlink, ele excluí a imagem fisicamente no servidor
            if (file_exists('uploads/produto/' . $_POST['excluirImagem'])) {
                unlink('uploads/produto/' . $_POST['excluirImagem']);
            }

            return header("Location: listaProduto.php?msgSucesso=Registro excluído com sucesso.");
        } else {
            return header("Location: listaProduto.php?msgError=Falha ao tentar excluír o registro.");
        }
    // se houver algum erro é retornado pelo bloco catch
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }