<?php

    require_once "helpers/protectUser.php";
    // carrega o formulário
    require_once "helpers/Formulario.php";
    // carrega o cabecalho
    require_once "comuns/cabecalho.php";
    // carrega a classe do banco de dados
    require_once "library/Database.php";
    // cria uma nova conexão com o banco de dados e atribui a $db
    $db = new Database();
    // cria um array vazio de $dados
    $dados = [];

    /*
    *   Se for alteração, exclusão ou visualização busca a UF pelo ID que foi recebido via método GET
    */
    if ($_GET['acao'] != "insert") {

        $dados = $db->dbSelect("SELECT * FROM produto_categoria WHERE ID_CATEGORIA = ?", 'first', [$_GET['id']]);

    }
?>
    <!-- inicio da página -->
    <main class="container mt-5">

        <div class="row">
            <div class="col-10">    
                <h2>Categoria de Produtos<?= subTitulo($_GET['acao']) ?></h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaProdutoCategoria.php" class="btn btn-outline-secondary btn-sm mt-3" title="Voltar">Voltar</a>
            </div>

        </div>

        <!--
            action => recebe a ação que foi adicionada no hyperlink da lista (insert, update, delete) mais Uf.php
        -->

        <!-- formulário que de acordo com a ação de click no botão vizualizar editar, remover, redireciona para uma página -->
        <form class="g-3" action="<?= $_GET['acao'] ?>ProdutoCategoria.php" method="POST">

            <!-- input hidden que pega o id de cada categoria e retorna se tiver e se não tiver retorna vazio -->
            <input type="hidden" name="ID_CATEGORIA" id="ID_CATEGORIA" value="<?= isset($dados->ID_CATEGORIA) ? $dados->ID_CATEGORIA : "" ?>">

            <div class="row">

                <div class="col-12">
                    <label for="DESCRICAO_CATEGORIA" class="form-label">Descrição</label>
                    <!-- verifica se existe alguma descrição em dados se tiver retorna e se não tiver retorna vazio -->
                    <input type="text" class="form-control" name="DESCRICAO_CATEGORIA" 
                        id="DESCRICAO_CATEGORIA" placeholder="Descrição da categoria" required
                        value="<?= isset($dados->DESCRICAO_CATEGORIA) ? $dados->DESCRICAO_CATEGORIA : "" ?>">
                </div>

                <div class="col-6">
                    <label for="tipo" class="form-label">Tipo categoria</label>
                    <select name="TIPO_CATEGORIA" id="TIPO_CATEGORIA" class="form-control" required>
                        <!-- Verifica se há algum TIPO_CATEGORIA em dados se houver seleciona e se não houver ele retorna vazio -->
                        <option value=""  <?= isset($dados->TIPO_CATEGORIA) ? $dados->TIPO_CATEGORIA == "" ? "selected" : "" : "" ?>>...</option>
                        <option value="1" <?= isset($dados->TIPO_CATEGORIA) ? $dados->TIPO_CATEGORIA == 1  ? "selected" : "" : "" ?>>Produto</option>
                        <option value="2" <?= isset($dados->TIPO_CATEGORIA) ? $dados->TIPO_CATEGORIA == 2  ? "selected" : "" : "" ?>>Serviço</option>
                    </select>
                </div>

                <div class="col-6">
                    <label for="STATUS_CATEGORIA" class="form-label">Status</label>
                    <select name="STATUS_CATEGORIA" id="STATUS_CATEGORIA" class="form-control" required>
                        <!-- Verifica se há algum STATUS_CATEGORIA em dados se houver seleciona e se não houver ele retorna vazio -->
                        <option value=""  <?= isset($dados->STATUS_CATEGORIA) ? $dados->STATUS_CATEGORIA == "" ? "selected" : "" : "" ?>>...</option>
                        <option value="1" <?= isset($dados->STATUS_CATEGORIA) ? $dados->STATUS_CATEGORIA == 1  ? "selected" : "" : "" ?>>Ativo</option>
                        <option value="2" <?= isset($dados->STATUS_CATEGORIA) ? $dados->STATUS_CATEGORIA == 2  ? "selected" : "" : "" ?>>Inativo</option>
                    </select>
                </div>

            </div>

            <div class="col-auto mt-5">
                <a href="listaProdutoCategoria.php" class="btn btn-outline-secondary btn-sm">Voltar</a>
                
                <?php if ($_GET['acao'] != "view"): /* botão gravar não é exibido na visualização dos dados */ ?>
                    <button type="submit" class="btn btn-primary btn-sm">Gravar</button>
                <?php endif; ?>
            </div>
        </form>

    </main>

    <?php
        // carrega o rodapé
        require_once "comuns/rodape.php";