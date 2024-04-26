<?php

    require_once "helpers/protectUser.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();

    $idComanda = (int)$_POST['idComanda'];
    $quantidade = (int)$_POST['quantidade'];
    $idProduto = (int)$_POST['idProduto'];

    // Obtém o item da comanda relacionado ao produto
    $itemComanda = $db->dbSelect(
        "SELECT * FROM itens_comanda WHERE COMANDA_ID_COMANDA = ? AND PRODUTOS_ID_PRODUTOS = ?",
        'first',
        [$idComanda, $idProduto]
    );

    // Se o item já existir na comanda, atualiza a quantidade
    if ($itemComanda) {
        $quantidadeAtual = $itemComanda->QUANTIDADE + $quantidade;
        $db->dbUpdate(
            "UPDATE itens_comanda SET QUANTIDADE = ? WHERE COMANDA_ID_COMANDA = ? AND PRODUTOS_ID_PRODUTOS = ?",
            [$quantidadeAtual, $idComanda, $idProduto]
        );
    } else {
        // Se o item não existir na comanda, insere um novo registro
        $db->dbInsert(
            "INSERT INTO itens_comanda (QUANTIDADE, COMANDA_ID_COMANDA, PRODUTOS_ID_PRODUTOS) VALUES (?, ?, ?)",
            [$quantidade, $idComanda, $idProduto]
        );
    }

    // Subtrai a quantidade adicionada do estoque
    $produto = $db->dbSelect("SELECT * FROM produto WHERE ID_PRODUTOS = ?", 'first', [$idProduto]);
    $custoTotalEstoque = ($produto->QTD_ESTOQUE) * ($produto->PRECO_FABRICA);
    $quantidadeEstoque = $produto->QTD_ESTOQUE - $quantidade;
    $db->dbUpdate("UPDATE produto SET QTD_ESTOQUE = ?, CUSTO_TOTAL_ESTOQUE = ? WHERE ID_PRODUTOS = ?", [$quantidadeEstoque, $custoTotalEstoque, $idProduto]);

    header("Location: visualizarItensComanda.php?idComanda=$idComanda");

    




