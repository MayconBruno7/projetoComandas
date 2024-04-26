<?php

    require_once "helpers/protectNivel.php";
    require_once "helpers/Formulario.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    $db = new Database();
    $dados = [];

    $aCategoria = $db->dbSelect("SELECT * FROM formas_pagamento ORDER BY DESCRICAO_FORMA_PAGAMENTO");

    /*
    *   Se for alteração, exclusão ou visualização busca a UF pelo ID que foi recebido via método GET
    */
    if ($_GET['acao'] != "insert") {

        $dados = $db->dbSelect("SELECT * FROM formas_pagamento WHERE ID_FORMA_PAGAMENTO = ?", 'first', [$_GET['id']]);

    }

?>
    <!-- inicio da página -->
    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>Forma de pagamento<?= subTitulo($_GET['acao']) ?></h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaFormaPagamento.php" class="btn btn-outline-secondary btn-sm" title="Voltar">Voltar</a>
            </div>

        </div>

        <!--
            action => recebe a ação que foi adicionada no hyperlink da lista (insert, update, delete) mais Uf.php
        -->

        <form class="g-3" action="<?= $_GET['acao'] ?>FormaPagamento.php" method="POST" 
            enctype="multipart/form-data">
            <!-- se existe dentro do objeto resultante $dados algum id, se sim ele retorna esse id que está em $dados -->
            <input type="hidden" name="id" id="id" value="<?= isset($dados->ID_FORMA_PAGAMENTO) ? $dados->ID_FORMA_PAGAMENTO : "" ?>">

            <div class="row">   
                <div class="col-12">
                    <label for="descricao" class="form-label">Descrição</label>
                    <!-- se existe dentro do objeto resultante $dados algum descricao, se sim ele retorna esse descricao que está em $dados -->
                    <input type="text" class="form-control" name="descricao" 
                        id="descricao" placeholder="Descrição da categoria" required maxlength="50"
                        value="<?= isset($dados->DESCRICAO_FORMA_PAGAMENTO) ? $dados->DESCRICAO_FORMA_PAGAMENTO : "" ?>">
                </div>

                <div class="col-6">
                    <label for="statusCadastro" class="form-label">Status</label>
                    <select name="statusCadastro" id="statusCadastro" class="form-control" required>
                        <!-- verifica se algum statusRegistro em $dados se sim retorna e seleciona -->
                        <option value=""  <?= isset($dados->SITUACAO_FORMA_PAGAMENTO) ? $dados->SITUACAO_FORMA_PAGAMENTO == "" ? "selected" : "" : "" ?>>...</option>
                        <option value="1" <?= isset($dados->SITUACAO_FORMA_PAGAMENTO) ? $dados->SITUACAO_FORMA_PAGAMENTO == 1  ? "selected" : "" : "" ?>>Ativo</option>
                        <option value="2" <?= isset($dados->SITUACAO_FORMA_PAGAMENTO) ? $dados->SITUACAO_FORMA_PAGAMENTO == 2  ? "selected" : "" : "" ?>>Inativo</option>
                    </select>
                </div>
            </div>  

            <div class="col-auto mt-5">
                <a href="listaformaPagamento.php" class="btn btn-outline-secondary btn-sm">Voltar</a>
                
                <?php if ($_GET['acao'] != "view"): /* botão gravar não é exibido na visualização dos dados */ ?>
                    <button type="submit" class="btn btn-primary btn-sm">Gravar</button>
                <?php endif; ?>
            </div>
        </form>

    </main>

    <!-- JS do ckeditor -->
    <script src="assets/ckeditor5/ckeditor5-build-classic/ckeditor.js"></script>

    <script type="text/javascript">

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