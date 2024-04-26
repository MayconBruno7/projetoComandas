<?php

    require_once "helpers/protectUser.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db                 = new Database();

    $idComanda          = (int)$_POST['idComanda'];
    $quantidadeRemover  = (int)$_POST['quantidadeRemover'];
    $idProduto          = (int)$_POST['idProduto'];

    // Obtém o item da comanda relacionado ao produto
    $itemComanda = $db->dbSelect(
        "SELECT * FROM itens_comanda WHERE COMANDA_ID_COMANDA = ? AND PRODUTOS_ID_PRODUTOS = ?",
        'first',
        [$idComanda, $idProduto]
    );

    if ($itemComanda) {

        $quantidadeAtual = $itemComanda->QUANTIDADE;

        // Verifica se a quantidade a ser removida não ultrapassa a quantidade atual na comanda
        if ($quantidadeRemover <= $quantidadeAtual) {
            // Subtrai a quantidade a ser removida da quantidade atual na comanda
            $novaQuantidadeComanda = $quantidadeAtual - $quantidadeRemover;

            // Atualiza a tabela itens_comanda com a nova quantidade
            $db->dbUpdate(
                "UPDATE itens_comanda SET QUANTIDADE = ? WHERE COMANDA_ID_COMANDA = ? AND PRODUTOS_ID_PRODUTOS = ?",
                [$novaQuantidadeComanda, $idComanda, $idProduto]
            );

            // Obtém informações do produto para atualizar o estoque
            $produto = $db->dbSelect(
                "SELECT * FROM produto WHERE ID_PRODUTOS = ?",
                'first',
                [$idProduto]
            );

            // Adiciona a quantidade removida de volta ao estoque
            $novaQuantidadeEstoque = ($produto->QTD_ESTOQUE) + ($quantidadeRemover);
            $custoTotalEstoque = ($produto->QTD_ESTOQUE) * ($produto->PRECO_FABRICA);

            $db->dbUpdate(
                "UPDATE produto SET QTD_ESTOQUE = ?, CUSTO_TOTAL_ESTOQUE = ? WHERE ID_PRODUTOS = ?",
                [$novaQuantidadeEstoque, $custoTotalEstoque, $idProduto]
            );


            if ($produto) {
                // Adiciona a quantidade removida de volta ao estoque
                $novaQuantidadeEstoque = $produto->QTD_ESTOQUE + $quantidadeRemover;
                $custoTotalEstoque = $novaQuantidadeEstoque * $produto->PRECO_FABRICA;

                $db->dbUpdate(
                    "UPDATE produto SET QTD_ESTOQUE = ?, CUSTO_TOTAL_ESTOQUE = ? WHERE ID_PRODUTOS = ?",
                    [$novaQuantidadeEstoque, $custoTotalEstoque, $idProduto]
                );

                // Remova registros com quantidade igual a zero, se necessário
                $qtdZero = $db->dbDelete(
                    "DELETE FROM itens_comanda
                    WHERE PRODUTOS_ID_PRODUTOS = ? AND COMANDA_ID_COMANDA = ? AND QUANTIDADE = 0",
                    [$idProduto, $idComanda]
                );

                header("Location: visualizarItensComanda.php?idComanda=$idComanda");
            } else {
                echo "Produto não encontrado na comanda.";
            }

            header("Location: visualizarItensComanda.php?idComanda=$idComanda");
        } else {
            echo "Quantidade a ser removida é maior que a quantidade atual na comanda.";
        }
    } else {
        echo "Produto não encontrado na comanda.";
    }
