<?php

    require_once "helpers/protectNivel.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    // Criando o objeto Db para classe de base de dados
    $db = new Database();

    $data = $db->dbSelect("SELECT 
        mesas.ID_MESA,
        mesas.DESCRICAO_MESA,
        mesas.SITUACAO_MESA,
        comanda.ID_COMANDA,
        comanda.SITUACAO_COMANDA,
        comanda.DESCRICAO_COMANDA,
        comanda.DATA_ABERTURA,
        comanda.DATA_FECHAMENTO
    FROM 
        mesas
    LEFT JOIN 
        comanda ON mesas.COMANDA_SITUACAO_COMANDA = comanda.ID_COMANDA");

    ?>

    <main class="container mt-5">
        <div class="row">
            <div class="col-10">
                <h2>Lista de mesas utilizadas</h2>
            </div>
            <div class="col-2 text-end">
                <a href="formMesa.php?acao=insert" class="btn btn-outline-success btn-sm" title="Novo">Nova</a>
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

        <table id="tbListaProduto" class="table table-striped table-hover table-bordered table-responsive-sm">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Descrição</th>
                    <th>Situação Mesa</th>
                    <th>Comanda</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data as $row) {
                    ?>
                    <tr>
                        <td><?= $row['ID_MESA'] ?></td>
                        <td><?= $row['DESCRICAO_MESA'] ?></td>
                        <td><?= situacaoMesa($row['SITUACAO_MESA']) ?></td>
                        <?php

                        $dataComanda = $db->dbSelect("SELECT ID_COMANDA, SITUACAO_COMANDA, DATA_FECHAMENTO FROM comanda WHERE SITUACAO_COMANDA = 1 AND MESA_ID_MESA = ?", 'all', [$row['ID_MESA']]);

                        // Verifica se há pelo menos uma comanda aberta
                        $existeComandaAberta = false;

                        foreach ($dataComanda as $comandaMesa) {
                            if ($comandaMesa['SITUACAO_COMANDA'] == 1) {
                                $existeComandaAberta = true;
                                break;
                            }
                        }
                        ?>
                        
                        <td>
                            <?php
                            if ($existeComandaAberta) {
                                foreach ($dataComanda as $comanda) {
                                    echo 'Comanda: ' . $comanda['ID_COMANDA'] . ', Situação: ' . getStatusComanda($comanda['SITUACAO_COMANDA']) . '<br>';
                                }
                            } else {
                                echo 'Sem comanda';
                            }
                            ?>
                        </td>

                        <td>
                            <a href="formMesa.php?acao=update&id=<?= $row['ID_MESA'] ?>" class="btn btn-outline-primary btn-sm" title="Alteração">Alterar</a>&nbsp;
                            <?php
                            // Exibe o botão de exclusão apenas se não houver comandas abertas
                            if (!$existeComandaAberta) {
                                ?>
                                <a href="formMesa.php?acao=delete&id=<?= $row['ID_MESA'] ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                                <?php
                            }
                            ?>
                            <a href="formMesa.php?acao=view&id=<?= $row['ID_MESA'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
                        </td>
                    </tr>
                    <?php
                }  
                ?>
            </tbody>
        </table>
    </main>

    <?php

        echo datatables("tbListaProduto");

        // Carrega o rodapé HTML
        require_once "comuns/rodape.php";
    ?>
