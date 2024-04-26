<?php 

    require_once "helpers/protectUser.php";
    require_once "comuns/cabecalho.php";
    require_once "helpers/Formulario.php";
    require_once "library/Database.php";

    // Criando o objeto Db para classe de base de dados
    $db = new Database();

    // Buscar a lista de Rotas na base de dados
    $data = $db->dbSelect("SELECT 
                            c.*,
                            IFNULL(DATE_FORMAT(DATA_ABERTURA, '%d/%m/%Y %H:%i:%s'), '') AS Data_Abertura_Formatada, 
                            IFNULL(DATE_FORMAT(DATA_FECHAMENTO, '%d/%m/%Y %H:%i:%s'), '') AS Data_Fechamento_Formatada

                        FROM comanda c 
                        ORDER BY ID_COMANDA DESC");   
                        
?>

    <main class="container mt-5">
        <div class="row">
            <div class="col-10">
                <h2>Lista de comandas</h2>
            </div>
            <div class="col-2 text-end">
                <a href="formComanda.php?acao=insert" class="btn btn-outline-success btn-sm" title="Novo">Nova</a>
            </div>

        </div>

        <?= getMensagem() ?>

        <table id="tbListaComandas" class="table table-striped table-hover table-bordered table-responsive-sm mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Data abertura</th>
                    <th>Data fechamento</th>
                    <th>Cliente</th>
                    <th>Mesa</th>
                    <th>Status</th>
                    <th>Opções</th>
                </tr>
            </<thead>
            <tbody>
                <?php
                    foreach ($data as $row) {
                        ?>
                        <tr>
                            <td><?= $row['ID_COMANDA'] ?></td>
                            <td><?= $row['Data_Abertura_Formatada'] ?></td>
                            <td><?= $row['Data_Fechamento_Formatada'] ?></td>
                            <td><?= $row['DESCRICAO_COMANDA'] ?></td>
                            <td><?= $row['MESA_ID_MESA'] ?></td>
                            <td><?= getStatusComanda($row['SITUACAO_COMANDA']) ?></td>
                            <td>
                                <a href="formComanda.php?acao=update&idComanda=<?= $row['ID_COMANDA'] ?>" class="btn btn-outline-primary btn-sm" title="Alteração">Alterar</a>&nbsp;
                                <a href="formComanda.php?acao=delete&idComanda=<?= $row['ID_COMANDA'] ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                                <a href="visualizarItensComanda.php?idComanda=<?= $row['ID_COMANDA'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
                                <a href="visualizarItensComanda.php?acao=close&idComanda=<?= $row['ID_COMANDA'] ?>&situacaoComanda=<?= $row['SITUACAO_COMANDA'] ?>" class="btn btn-outline-warning btn-sm" title="Fechar comanda"><?= ($row['SITUACAO_COMANDA']) == 1 ? 'Fechar comanda' : 'Abrir comanda' ?></a>
                                
                                <!-- <button id="<?= $row['ID_COMANDA'] ?>" class="btn btn-outline-primary btn-sm" title="Alteração" onclick="alterar_status(this)"> <?= isset($row['SITUACAO_COMANDA']) ? ($row['SITUACAO_COMANDA'] == 1  ? "Fechar" : "Abrir") : "ERRO"?> </button>                             -->
                            
                            </td>
                        </tr>

                        <?php
                        // Adicionando verificação antes da atualização da mesa
                            if (isset($row['SITUACAO_COMANDA'])) {
                                $situacaoMesa = ($row['SITUACAO_COMANDA'] == 1) ? 2 : 1;
                                $ID_MESA = $row['MESA_ID_MESA'];

                                // Verifica se a mesa existe antes de realizar a atualização
                                $mesaExists = $db->dbSelect("SELECT ID_MESA FROM mesas WHERE ID_MESA = ?", 'first', [$ID_MESA]);

                                if ($mesaExists) {
                                    $db->dbUpdate("UPDATE mesas SET SITUACAO_MESA = ? WHERE ID_MESA = ?", [$situacaoMesa, $ID_MESA]);
                                }
                            }
                        ?>
                        <?php
                    }
                    ?>
            </tbody>
        </table>
    </main>

    <script>

        const tabela = <?= json_encode($data) ?>;
        var comanda;

        function alterar_status(botao){

            let id = +botao.id;

            comanda = tabela.find(item => item.ID_COMANDA === id);
            
            
            let Status = <?= $row['SITUACAO_COMANDA'] ;
            // id = <?= $row['ID_COMANDA'] ?>;
            if(Status == 1){
                Status = 2;
            }else{
                Status = 1;
            }
            window.location.href = "alterarStatusComanda.php?status="+Status+"&id="+id;
            }

            // Chamando a função para atualizar a situação da mesa
            atualizarSituacaoMesa(<?= $ID_MESA ?>, <?= $situacaoMesa ?>);

            // Função para atualizar a situação da mesa
            function atualizarSituacaoMesa(idMesa, novaSituacao) {
                $.ajax({
                    type: 'POST',
                    url: 'atualizarSituacaoMesa.php',  // Substitua pelo caminho do seu script de atualização no servidor
                    data: { idMesa: idMesa, novaSituacao: novaSituacao },
                    success: function(response) {
                        // A resposta pode ser tratada conforme necessário
                        console.log(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        
    </script>

    <?php

        echo datatables("tbListaComandas");

        // Carrega o ropdapé HTML
        require_once "comuns/rodape.php";
    ?>
