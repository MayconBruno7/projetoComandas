<?php

    require_once "helpers/protectUser.php";
    require_once "helpers/Formulario.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();
    $dados = [];

    $dados = $db->dbSelect("SELECT * FROM comanda WHERE ID_COMANDA = ?", 'first', [$_GET['idComanda']]);

    $produtos = $db->dbSelect("SELECT * FROM produto ORDER BY descricao");
    
    $produtosComanda = $db->dbSelect("SELECT itens_comanda.*, produto.*, produto.DESCRICAO, produto.VALOR_UNITARIO 
    FROM itens_comanda
    INNER JOIN produto ON itens_comanda.PRODUTOS_ID_PRODUTOS = produto.ID_PRODUTOS
    WHERE COMANDA_ID_COMANDA = ? 
    ORDER BY produto.DESCRICAO", 'all', [$_GET['idComanda']]);
   
    $formasPagamento = $db->dbSelect("SELECT * FROM formas_pagamento");

    $finComanda = $db->dbSelect("SELECT * FROM fin_comanda WHERE  COMANDA_ID_COMANDA = ?", 'first', [$_GET['idComanda']]);
    
?>
    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2> <?= (isset($_GET['acao']) && $_GET['acao'] == 'close') ? "Fechamento de comanda" : "Produtos Comanda" ?> </h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaProduto.php?acao=insert&idComanda=<?= $_GET['idComanda'] ?>" class="btn btn-outline-success btn-sm" title="Nova">Novo</a>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <?php if (isset($_GET['msgSucesso'])): ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?= $_GET['msgSucesso'] ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                <?php endif; ?>

                <?php if (isset($_GET['msgError'])): ?>

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?= $_GET['msgError'] ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                <?php endif; ?>
            </div>
        </div>
        
        <?php if(isset($_GET['acao']) && $_GET['acao'] == 'close') : ?>
        <form class="g-3" action="fechaComanda.php?idComanda=<?= $_GET['idComanda'] ?>" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" id="id" value="<?= isset($dados->ID_PRODUTOS) ? $dados->ID_PRODUTOS : "" ?>">
            <input type="hidden" name="status" id="status" value="<?= isset($_GET['situacaoComanda']) ? $_GET['situacaoComanda'] : '' ?>">

            <div class="row">

                <div class="col-12">
                    <label for="descricao" class="form-label">Nome do cliente</label>
                    <input type="text" class="form-control" name="descricao" 
                        id="descricao" placeholder="Descrição do produto" required maxlength="50"
                        value="<?= isset($dados->DESCRICAO_COMANDA) ? $dados->DESCRICAO_COMANDA : "" ?>">
                </div>

                <div class="col-6 mt-3">
                <label for="ID_COMANDA" class="form-label">Numero da comanda</label>
                    <input type="text" class="form-control" name="ID_COMANDA" 
                        id="ID_COMANDA" placeholder="Descrição do produto" required maxlength="50"
                        value="<?= isset($dados->ID_COMANDA) ? $dados->ID_COMANDA : "" ?>">
                </div>

                <div class="col-6 mt-3 mb-3">
                    <label for="FORMA_PAGAMENTO" class="form-label">Forma de pagamento</label>
                    <select name="FORMA_PAGAMENTO" id="FORMA_PAGAMENTO" class="form-control" required> 
                        <option value=""  <?= isset($finComanda->PAGAMENTO_ID_PAGAMENTO) ? $finComanda->PAGAMENTO_ID_PAGAMENTO == "" ? "selected" : "" : "" ?>>...</option>
                        <option value="1" <?= isset($finComanda->PAGAMENTO_ID_PAGAMENTO) ? $finComanda->PAGAMENTO_ID_PAGAMENTO == 1  ? "selected" : "" : "" ?>>Dinheiro</option>
                        <option value="2" <?= isset($finComanda->PAGAMENTO_ID_PAGAMENTO) ? $finComanda->PAGAMENTO_ID_PAGAMENTO == 2  ? "selected" : "" : "" ?>>Cartão de crédito</option>
                        <option value="3" <?= isset($finComanda->PAGAMENTO_ID_PAGAMENTO) ? $finComanda->PAGAMENTO_ID_PAGAMENTO == 3  ? "selected" : "" : "" ?>>Cartão de débito</option>
                        <option value="4" <?= isset($finComanda->PAGAMENTO_ID_PAGAMENTO) ? $finComanda->PAGAMENTO_ID_PAGAMENTO == 4  ? "selected" : "" : "" ?>>Pix</option>
                    </select>
                </div>
            </div>
            
            <?php endif; ?>
            <table id="tbListaProduto" class="table table-striped table-hover table-bordered table-responsive-sm mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Numero Mesa</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor Unidade</th>
                        <th>Valor Total Produto</th>
                        <th>Opções</th>
                    </tr>
                </<thead>
                <tbody>

                    <?php
                        $contador = 0;
                        $total = 0;

                        foreach ($produtosComanda as $row) {
                            $contador++;
                    ?>
                            <tr>
                                <td><?= $dados->MESA_ID_MESA ?></td>
                                <td><?= $row['DESCRICAO'] ?></td>
                                <td><?= $row['QUANTIDADE'] ?></td>
                                <td><?= number_format($row['VALOR_UNITARIO'], 2, ",", ".")  ?> </td>
                                <td><?= number_format(total_valor($row["QUANTIDADE"], $row["VALOR_UNITARIO"]), 2, ',', '.') ?></td>
                                
                                <td>
                                    <!-- <a href="formProdutoComanda.php?acao=update&id_produtos=<?= $row['PRODUTOS_ID_PRODUTOS'] ?>&idComanda=<?= $row['COMANDA_ID_COMANDA'] ?>" class="btn btn-outline-primary btn-sm"   title="Alteração">Alterar</a>&nbsp; -->
                                    <a href="listaProduto.php?acao=delete&id_produtos=<?= $row['PRODUTOS_ID_PRODUTOS'] ?>&idComanda=<?= $row['COMANDA_ID_COMANDA'] ?>&qtd_produto=<?= $row['QUANTIDADE'] ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                                    <a href="produtos.php?acao=view&id_produtos=<?= $row['PRODUTOS_ID_PRODUTOS'] ?>&idComanda=<?= $row['COMANDA_ID_COMANDA'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a></td>
                            </tr>
                        
                    <?php
                            $total = $total + total_valor($row["QUANTIDADE"],$row["VALOR_UNITARIO"]);
                            
                        }
                    ?>
                </tbody>
            </table>

            <input type="hidden" name="totalComanda" value="<?= $total ?>">

            <p><h2 align='center'>Valor Total: R$ <?= number_format($total, 2, ',', '.')?></h2></p>            
            
            <div class="container text-center mt-5">
                <?php if (isset($_GET["idComanda"])) : /* botão gravar não é exibido na visualização dos dados */ ?>
                    <a class="btn btn-primary" href="listaComanda.php">Voltar</a>
                <?php endif; ?>

                <?php if(isset($_GET['acao']) && $_GET['acao'] == 'close') : ?>
                    <button type="submit" class="btn btn-primary"><?= ($_GET['situacaoComanda']) == 1 ? 'Fechar comanda' : 'Abrir comanda' ?></a>
                <?php endif; ?>
            </div>

        </form>

    </main>

    <?php

        echo datatables("tbListaProduto");

        // Carrega o ropdapé HTML
        require_once "comuns/rodape.php";