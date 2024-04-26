<?php
    require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    // Carrega cabeçalho HTML (header, nav, etc...)
    require_once "comuns/cabecalho.php";

    // carregando os helpers
    require_once "helpers/Formulario.php";

    // Criando o objeto Db para classe de base de dados
    $db = new Database();

    // Buscar a lista de Categorias de Produtos na base de dados

    $data = $db->dbSelect("SELECT * FROM produto_categoria ORDER BY DESCRICAO_CATEGORIA");
?>

    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>Lista Categoria de Produtos/Serviços</h2>
            </div>
            <div class="col-2 text-end">
                <a href="formProdutoCategoria.php?acao=insert" class="btn btn-outline-success btn-sm" title="Novo">Nova</a>
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

        <table id="tbListaProdutoCategoria" class="table table-striped table-hover table-bordered table-responsive-sm mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Descrição</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Opções</th>
                </tr>
            </<thead>
            <tbody>
                <?php
                    foreach ($data as $row) {
                        ?>
                       <tr>
                            <td><?= $row['ID_CATEGORIA'] ?></td>
                            <td><?= $row['DESCRICAO_CATEGORIA'] ?></td>
                            <td><?= ($row['TIPO_CATEGORIA'] == 1 ? "Produto" : ($row['TIPO_CATEGORIA'] == 2 ? "Serviço" : "...")) ?></td>
                            <td><?= getStatusDescricao($row['STATUS_CATEGORIA']) ?></td>
                            <td>
                                <a href="formProdutoCategoria.php?acao=update&id=<?= $row['ID_CATEGORIA'] ?>" class="btn btn-outline-primary btn-sm"   title="Alteração">Alterar</a>&nbsp;
                                <a href="formProdutoCategoria.php?acao=delete&id=<?= $row['ID_CATEGORIA'] ?>" class="btn btn-outline-danger btn-sm"    title="Exclusão">Excluir</a>&nbsp;
                                <a href="formProdutoCategoria.php?acao=view&id=<?= $row['ID_CATEGORIA'] ?>"   class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
            
        </table>

    </main>

    <?php

        echo datatables('tbListaProdutoCategoria');

        // Carrega o ropdapé HTML
        require_once "comuns/rodape.php";