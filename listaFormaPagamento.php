<?php 

    require_once "helpers/protectNivel.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    $db = new Database();

    $data = $db->dbSelect("SELECT * FROM formas_pagamento ORDER BY ID_FORMA_PAGAMENTO");
?>
    <main class="container mt-5">
        <div class="row">
            <div class="col-10">
                <h2>Lista Forma de pagamento</h2>
            </div>

            <div class="col-2 text-end">               
                <a href="formFormaPagamento.php?acao=insert" class="btn btn-outline-success btn-sm">Nova</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php if(isset($_GET['msgSucesso'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?= $_GET['msgSucesso'] ?></strong>
                        <button type="button" class="btn-close" data-bs-dismimss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if(isset($_GET['msgError'])) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?= $_GET['msgError'] ?></strong>
                        <button type="button" class="btn-close" data-bs-dismimss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
             </div>
        </div>

        <table id="tbListaProduto" class="table table-striped table-hover table-bordered table-responsive-sm mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Descrição</th>
                    <th>Situação</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tbody>

                <?php 
                    foreach ($data as $row) {
                ?>
                <tr>
                    <td><?= $row['ID_FORMA_PAGAMENTO'] ?></td>
                    <td><?= $row['DESCRICAO_FORMA_PAGAMENTO'] ?></td>
                    <td><?= getStatusDescricao($row['SITUACAO_FORMA_PAGAMENTO']) ?></td>
                    <td>
                        <a href="formFormaPagamento.php?acao=update&id=<?= $row['ID_FORMA_PAGAMENTO'] ?>"  class="btn btn-outline-primary btn-sm">Atualizar</a>&nbsp;
                        <a href="formFormaPagamento.php?acao=delete&id=<?= $row['ID_FORMA_PAGAMENTO'] ?>" class="btn btn-outline-danger btn-sm">Excluir</a>&nbsp;
                        <a href="formFormaPagamento.php?acao=view&id=<?= $row['ID_FORMA_PAGAMENTO'] ?>" class="btn btn-outline-secondary btn-sm">Visualizar</a>
                    </td>
                </tr>
            
                <?php } ?>
            </tbody>
        </table>
    </main>

    <?php 
    
        echo dataTables('tbListaProduto');

        require_once "comuns/rodape.php";
    ?>