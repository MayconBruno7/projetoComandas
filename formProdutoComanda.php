<?php

    require_once "helpers/Formulario.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();
    $dados = [];

    $id_produtos = isset($_GET['id_produtos']) ? $_GET['id_produtos'] : '';
    $id_comanda = isset($_GET['idComanda']) ? $_GET['idComanda'] : '';

    $aCategoria = $db->dbSelect("SELECT * FROM produto_categoria ORDER BY DESCRICAO_CATEGORIA");

    /*
    *   Se for alteração, exclusão ou visualização busca a UF pelo ID que foi recebido via método GET
    */
    if ($_GET['acao'] != "insert") {

        $dados = $db->dbSelect("SELECT * FROM produto WHERE ID_PRODUTOS = ?", 'first', [$id_produtos]);
    }
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

        <form class="g-3" action="<?= $_GET['acao'] ?>ProdutoComanda.php" method="POST" 
            enctype="multipart/form-data">

            <input type="hidden" name="id" id="id" value="<?= isset($dados->ID_PRODUTOS) ? $dados->ID_PRODUTOS : "" ?>">

            <div class="row">

                <div class="col-12">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" name="descricao" 
                        id="descricao" placeholder="Descrição da categoria" required maxlength="50"
                        value="<?= isset($dados->DESCRICAO) ? $dados->DESCRICAO : "" ?>">
                </div>

                <div class="col-12">
                    <label for="caracteristicas" class="form-label">Características</label>
                    <textarea class="form-control" name="caracteristicas" id="caracteristicas"><?= isset($dados->CARACTERISTICAS) ? $dados->CARACTERISTICAS : "" ?></textarea>
                </div>
            </div>

            <?php if ($_GET['acao'] == "view") : ?>
                <div class="row">
                    <div class="col-6">
                        <label for="QTD_ESTOQUE" class="form-label">Qtde Em Estoque</label>
                        <input type="text" class="form-control" name="QTD_ESTOQUE" id="QTD_ESTOQUE"  dir="rtl"
                                value="<?= isset($dados->QTD_ESTOQUE) ? $dados->QTD_ESTOQUE : '0,000' ?>">
                    </div>

                    <div class="col-6">
                        <label for="VALOR_UNITARIO" class="form-label">Preço de Venda</label>
                        <input type="text" class="form-control" name="VALOR_UNITARIO" id="VALOR_UNITARIO" dir="rtl"
                                value="<?= isset($dados->VALOR_UNITARIO) ? $dados->VALOR_UNITARIO : '0,00' ?>">
                    </div>
                </div>
            <?php endif; ?>

            <h4 class="mt-3 mb-3">Imagem do Produto</h4>

            <?php if ($_GET['acao'] != "insert") : ?>
                <div class="row">
                    <div class="form-group col-3">
                        <!-- verifica se algum precoVenda em $dados se sim retorna  -->
                        <img src="uploads/produto/<?= $dados->IMAGEM ?>" alt="..." class="img-thumbnail" width="200" height="200">   
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($_GET['acao'] != "view") : ?>
            <div class="row mt-3">
                <div class="form-group col-12 col-md-4">
                    <label for="imagem" class="form-label font-weight-bold">Imagem<span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file" name='imagem' id="imagem" accept="image/png, image/jpeg, image/jpg" <?= $_GET['acao'] == 'insert' ? 'required' : '' ?>>
                </div>
            </div>
            <?php endif; ?>
            <!-- input hidden para pegar o id e excluir a imagem -->
            <input type="hidden" name="id" id="id" value="<?= (isset($dados->ID_PRODUTOS) ? $dados->ID_PRODUTOS : "") ?>">
            <input type="hidden" name="excluirImagem" id="excluirImagem" value="<?= (isset($dados->IMAGEM) ? $dados->IMAGEM : "") ?>">
            <input type="hidden" name="idComanda" value="<?= $id_comanda ?>">
            <input type="hidden" name="id_produtos" value="<?= $id_produtos ?>">

            <div class="col-auto mt-5">
                <a href="visualizarItensComanda.php?idComanda=<?= $id_comanda ?>" class="btn btn-outline-secondary btn-sm">Voltar</a>
                
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