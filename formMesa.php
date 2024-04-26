<?php

    require_once "helpers/protectNivel.php";
    require_once "helpers/Formulario.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();
    $dados = [];

    /*
    *   Se for alteração, exclusão ou visualização busca a UF pelo ID que foi recebido via método GET
    */
    if ($_GET['acao'] != "insert") {

        $dados = $db->dbSelect("SELECT * FROM mesas WHERE ID_MESA = ?", 'first', [$_GET['id']]);
    }

    if (($_GET['acao'] == "delete") && $dados->SITUACAO_MESA == 2) {
        return header("Location: listaMesa.php?msgError=Não é possível excluir uma mesa com comanda em aberto");
    }

?>
    <!-- inicio da página -->
    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>Mesa <?= subTitulo($_GET['acao']) ?></h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaMesa.php" class="btn btn-outline-secondary btn-sm" title="Voltar">Voltar</a>
            </div>

        </div>

        <!--
            action => recebe a ação que foi adicionada no hyperlink da lista (insert, update, delete) mais Uf.php
        -->

        <form class="g-3" action="<?= $_GET['acao'] ?>Mesa.php" method="POST" 
            enctype="multipart/form-data">

            <input type="hidden" name="id" id="id" value="<?= isset($dados->ID_MESA) ? $dados->ID_MESA : "" ?>">

            <div class="row">

                <div class="col-12">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" name="descricao" 
                        id="descricao" placeholder="Descrição da mesa" required maxlength="50"
                        value="<?= isset($dados->DESCRICAO_MESA) ? $dados->DESCRICAO_MESA : "" ?>">
                </div>

            </div>

            <div class="col-auto mt-5">
                <a href="listaMesa.php" class="btn btn-outline-secondary btn-sm">Voltar</a>
                
                <?php if ($_GET['acao'] != "view"): /* botão gravar não é exibido na visualização dos dados */ ?>
                    <button type="submit" class="btn btn-primary btn-sm">Gravar</button>
                <?php endif; ?>
            </div>
        </form>

    </main>

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