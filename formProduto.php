<?php

    require_once "helpers/protectNivel.php";
    require_once "helpers/Formulario.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();
    $dados = [];

    $aCategoria = $db->dbSelect("SELECT * FROM produto_categoria ORDER BY DESCRICAO_CATEGORIA");

    /*
    *   Se for alteração, exclusão ou visualização busca a UF pelo ID que foi recebido via método GET
    */
    if ($_GET['acao'] != "insert") {

        $dados = $db->dbSelect("SELECT * FROM produto WHERE ID_PRODUTOS = ?", 'first', [$_GET['id']]);
    }

    $custoTotalEstoque;
?>
    <!-- inicio da página -->
    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>Produtos/Serviço<?= subTitulo($_GET['acao']) ?></h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaProduto.php" class="btn btn-outline-secondary btn-sm mt-3" title="Voltar">Voltar</a>
            </div>

        </div>

        <!--
            action => recebe a ação que foi adicionada no hyperlink da lista (insert, update, delete) mais Uf.php
        -->

        <form class="g-3" action="<?= $_GET['acao'] ?>Produto.php" method="POST" 
            enctype="multipart/form-data">

            <input type="hidden" name="id" id="id" value="<?= isset($dados->ID_PRODUTOS) ? $dados->ID_PRODUTOS : "" ?>">

            <div class="row">

                <div class="col-10">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" name="descricao" 
                        id="descricao" placeholder="Descrição do produto" required maxlength="50"
                        value="<?= isset($dados->DESCRICAO) ? $dados->DESCRICAO : "" ?>">
                </div>

                <div class="col-2">
                    <label for="LOTE" class="form-label">Lote</label>
                    <input type="text" class="form-control" name="LOTE" id="LOTE"
                            value="<?= isset($dados->LOTE) ? $dados->LOTE : '' ?>" placeholder="EX: Lote 1">
                </div>

                <div class="col-6">
                    <label for="ID_PRODUTO_CATEGORIA" class="form-label">Categoria</label>
                    <select name="ID_PRODUTO_CATEGORIA" id="ID_PRODUTO_CATEGORIA" class="form-control" required>
                        <option value=""  <?= isset($dados->ID_PRODUTO_CATEGORIA) ? $dados->ID_PRODUTO_CATEGORIA == "" ? "selected" : "" : "" ?>>...</option>

                        <?php foreach ($aCategoria as $item): ?>
                            <option value="<?= $item['ID_CATEGORIA'] ?>" <?= (isset($dados->ID_PRODUTO_CATEGORIA) ? ($item['ID_CATEGORIA'] == $dados->ID_PRODUTO_CATEGORIA ?  "selected" : "" ) : "") ?>><?= $item['DESCRICAO_CATEGORIA'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-6">
                    <label for="STATUS_PRODUTO" class="form-label">Status</label>
                    <select name="STATUS_PRODUTO" id="STATUS_PRODUTO" class="form-control" required>
                        <option value=""  <?= isset($dados->STATUS_PRODUTO) ? $dados->STATUS_PRODUTO == "" ? "selected" : "" : "" ?>>...</option>
                        <option value="1" <?= isset($dados->STATUS_PRODUTO) ? $dados->STATUS_PRODUTO == 1  ? "selected" : "" : "" ?>>Ativo</option>
                        <option value="2" <?= isset($dados->STATUS_PRODUTO) ? $dados->STATUS_PRODUTO == 2  ? "selected" : "" : "" ?>>Inativo</option>
                    </select>
                </div>


                <div class="<?= ($_GET['acao'] == 'insert') ? 'col-4' : 'col-6' ?>">
                    <label for="QTD_ESTOQUE" class="form-label">Qtde Em Estoque</label>
                    <input type="text" class="form-control" name="QTD_ESTOQUE" id="QTD_ESTOQUE"  dir="rtl"
                        value="<?= isset($dados->QTD_ESTOQUE) ? number_format($dados->QTD_ESTOQUE, 0, ',', '.') : '' ?>">
                </div>

                <div class="<?= ($_GET['acao'] == 'insert') ? 'col-4' : 'col-6' ?>">
                    <label for="PRECO_FABRICA" class="form-label">Preço de fabrica</label>
                    <input type="text" class="form-control" name="PRECO_FABRICA" id="PRECO_FABRICA"  dir="rtl"
                        value="<?= isset($dados->PRECO_FABRICA) ? number_format($dados->PRECO_FABRICA, 0, ',', '.') : '' ?>">
                </div>

                <?php if ($_GET['acao'] != 'insert') : ?>
                <div class="col-6">
                    <label for="CUSTO_TOTAL_ESTOQUE" class="form-label">Custo Total Estoque</label>
                    <input type="text" class="form-control" name="CUSTO_TOTAL_ESTOQUE" id="CUSTO_TOTAL_ESTOQUE" dir="rtl" 
                        value="<?= isset($dados->CUSTO_TOTAL_ESTOQUE) ? number_format($dados->CUSTO_TOTAL_ESTOQUE, 2, ',', '.') : '' ?>" disabled>
                            
                </div>
                <?php endif; ?>

                <div class="<?= ($_GET['acao'] == 'insert') ? 'col-4' : 'col-6' ?>">
                    <label for="VALOR_UNITARIO" class="form-label">Preço de Venda</label>
                    <input type="text" class="form-control" name="VALOR_UNITARIO" id="VALOR_UNITARIO" dir="rtl"
                        value="<?= isset($dados->VALOR_UNITARIO) ? number_format($dados->VALOR_UNITARIO, 2, ',', '.') : '' ?>">
                </div>

                <div class="col-12">
                    <label for="caracteristicas" class="form-label">Características</label>
                    <textarea class="form-control" name="caracteristicas" id="caracteristicas"><?= isset($dados->CARACTERISTICAS) ? $dados->CARACTERISTICAS : "" ?></textarea>
                </div>
            </div>

            <h4 class="mt-3 mb-3">Imagem do Produto</h4>

            <?php if ($_GET['acao'] != "insert"): ?>
                <div class="row">
                    <div class="form-group col-3">
                        <!-- verifica se algum precoVenda em $dados se sim retorna  -->
                        <img src="uploads/produto/<?= $dados->IMAGEM ?>" alt="..." class="img-thumbnail" width="200" height="200">   
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mt-3">
                <div class="form-group col-12 col-md-4">
                    <label for="imagem" class="form-label font-weight-bold">Imagem<span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file" name='imagem' id="imagem" accept="image/png, image/jpeg, image/jpg" <?= $_GET['acao'] == 'insert' ? 'required' : '' ?>>
                </div>
            </div>
            
            <!-- input hidden para pegar o id e excluir a imagem -->
            <input type="hidden" name="id" id="id" value="<?= (isset($dados->ID_PRODUTOS) ? $dados->ID_PRODUTOS : "") ?>">
            <input type="hidden" name="excluirImagem" id="excluirImagem" value="<?= (isset($dados->IMAGEM) ? $dados->IMAGEM : "") ?>">

            <div class="col-auto mt-5">
                <a href="listaProduto.php" class="btn btn-outline-secondary btn-sm">Voltar</a>
                
                <?php if ($_GET['acao'] != "view"): /* botão gravar não é exibido na visualização dos dados */ ?>
                    <button type="submit" class="btn btn-primary btn-sm">Gravar</button>
                <?php endif; ?>
            </div>
        </form>

    </main>

    <!-- JS do ckeditor -->
    <script src="assets/ckeditor5/ckeditor5-build-classic/ckeditor.js"></script>

    <script type="text/javascript">
        // faz uma mascara para cada tipo de item 
        $(document).ready( function() { 
            $('#QTD_ESTOQUE').mask('##.###.###.##0,000', {reverse: true});
            $('#CUSTO_TOTAL_ESTOQUE').mask('##.###.###.##0,00', {reverse: true});
            $('#VALOR_UNITARIO').mask('##.###.###.##0,00', {reverse: true});
        })

        // JS do ckEditor
        ClassicEditor
            .create(document.querySelector('#caracteristicas'))
            .catch( error => {
                console.error(error);
            });

    </script>

    <?php
        // carrega o rodapé
        require_once "comuns/rodape.php";