<?php

    require_once "helpers/protectUser.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();

    // Verifique se o campo id_comanda não está vazio
    if (empty($_POST['ID_COMANDA'])) {
            header("Location: visualizarItensComanda.php?acao=close&idComanda=". $_POST['ID_COMANDA'] . "&msgError=Id da comanda vazio");
            exit();
        }

    // Verifique se o campo totalComanda não está vazio
    if (empty($_POST['totalComanda'])) {
        header("Location: listaComanda.php?acao=close&idComanda=". $_POST['ID_COMANDA'] . "&msgSucesso=Comanda cancelada"); 
    }

    // Obtenha o ID da comanda e a forma de pagamento do formulário
    $idComanda = $_POST['ID_COMANDA'];
    $formaPagamento = $_POST['FORMA_PAGAMENTO'];
    $totalComanda = $_POST['totalComanda'];

    // Verifique se a comanda já existe na tabela fin_comanda
    $comandaExists = $db->dbSelect("SELECT * FROM fin_comanda WHERE COMANDA_ID_COMANDA = ?", 'first', [$idComanda]);

    if ($comandaExists) {

        // A comanda já existe, então atualize as colunas necessárias na tabela fin_comanda
        $result = $db->dbUpdate(
            "UPDATE fin_comanda SET PAGAMENTO_ID_PAGAMENTO = ?, VALOR_PAGAMENTO = ? WHERE COMANDA_ID_COMANDA = ?",
            [$formaPagamento, $totalComanda, $idComanda]
        );
    } else {

        // A comanda não existe, então insira na tabela fin_comanda
        $resultadoInsercao = $db->dbInsert("INSERT INTO fin_comanda (COMANDA_ID_COMANDA, PAGAMENTO_ID_PAGAMENTO, VALOR_PAGAMENTO) 
                VALUES (?, ?, ?)",
                [
                    $_POST['ID_COMANDA'],
                    $_POST['FORMA_PAGAMENTO'],
                    $_POST['totalComanda']
                ]
        );
    }

    // Verifique o resultado
    if ($resultadoInsercao) {
        // header("Location: listaComanda.php?msgSucesso=A comanda foi fechada");
        echo "Erro ao alterar o status da comanda";
         
    } else {
        header("Location: listaComanda.php?msgError=Falha ao tentar fechar comanda ID = " . $_POST['ID_COMANDA']);

    }

    // Adicionando verificação antes da atualização da mesa
    if (isset($_POST['SITUACAO_COMANDA'])) {
        $situacaoMesa = ($_POST['SITUACAO_COMANDA'] == 1) ? 2 : 1;
        $ID_MESA = $$_POST['MESA_ID_MESA'];

        // Verifica se a mesa existe antes de realizar a atualização
        $mesaExists = $db->dbSelect("SELECT ID_MESA FROM mesas WHERE ID_MESA = ?", 'first', [$ID_MESA]);

        if ($mesaExists) {
            $db->dbUpdate("UPDATE mesas SET SITUACAO_MESA = ? WHERE ID_MESA = ?", [$situacaoMesa, $ID_MESA]);
        }
    }

    if (isset($_POST['status'])) {

        try {
            
            $id = $_GET['idComanda'];
            $status = $_POST['status'];

            if ($status == 1) {
                
                // Defina o fuso horário para a sua localidade (por exemplo, 'America/Sao_Paulo')
                $timezone = new DateTimeZone('America/Sao_Paulo');

                // Crie um objeto DateTime com a localidade configurada
                $date = new DateTime('now', $timezone);

                // Obtenha a data e hora no formato desejado
                $horario = $date->format('Y-m-d H:i:s');

                $result = $db->dbUpdate("UPDATE comanda
                                        SET SITUACAO_COMANDA = ?,
                                        DATA_FECHAMENTO = ?
                                        WHERE ID_COMANDA = ?",

                                        [
                                            2,
                                            $horario,
                                            $id
                                            
                                        ]);
    
                if ($result) {
                    header("Location: listaComanda.php?msgSucesso=A comanda foi fechada");
                } else {
                    echo "Erro ao alterar o status da comanda";
                }

            } else {
                $result = $db->dbUpdate("UPDATE comanda
                                        SET SITUACAO_COMANDA = ?,
                                        DATA_FECHAMENTO = ?
                                        WHERE ID_COMANDA = ?",

                                        [
                                            1,
                                            null,
                                            $id
                                            
                                        ]);
    
                if ($result) {
                    header("Location: listaComanda.php?msgSucesso=A comanda foi aberta");
                } else {
                    echo "Erro ao alterar o status da comanda";
                }
            }

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
?>

<script>

    
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