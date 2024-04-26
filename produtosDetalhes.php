<?php

    require_once "helpers/protectUser.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    $db = new Database();

    $data = $db->dbSelect("SELECT 
	                        c.*,
	                        CAST(QTD_ESTOQUE AS DECIMAL(15,2)) AS Qtd_Estoque_Formatado,
	                        CAST(CUSTO_TOTAL_ESTOQUE AS DECIMAL(15,2)) AS Custo_Estoque_Formatado,
	                        CAST(VALOR_UNITARIO AS DECIMAL(15,2)) AS Valor_Unitario_Formatado,
	                        CAST(PRECO_FABRICA AS DECIMAL(15,2)) AS Preco_Fabrica_Formatado


                        FROM(
	                        SELECT * 

	                        FROM produto p
                        )c

                        WHERE ID_PRODUTOS = ?", 'first', [$_GET['id']]);

    // Verifica se há dados
    if (!empty($data)) {
        $item = $data; // Atribui o único item ao $item
?>

    <main>
        <br>
        <br>
        <br>
        <br>
        <div class="container container-fluid">
            <div class="card col-12 align-items-center text-center pt-3" id="card-<?= $item->ID_PRODUTOS ?>">
                <img src="uploads/produto/<?= $item->IMAGEM ?>" class="img-fluid" alt="..."
                    style="width: 200px; height: 200px; max-width: 200px; max-height: 200px;">
                <div class="card-body">
                    <h5 class="card-title"> <?= $item->DESCRICAO ?> </h5>
                    <p class="card-text"> R$ <strong><?= number_format($item->Valor_Unitario_Formatado, 2, ",", ".") ?></strong> </p>
                    <p class="card-text"><?= $item->CARACTERISTICAS ?></p>
                    <p class="card-text">Quantidade em estoque: <b><?= number_format($item->Qtd_Estoque_Formatado, 2, ",", ".") ?></b></p>
                    <button class="btn btn-primary" onclick="goBack()">Voltar</button>


                    


                </div>
            </div>
        </div>
    </main>
    <script>

        function goBack() {
            window.history.back();
        }

    </script>

    <?php

        } else {
            echo "Nenhum dado encontrado.";
        }

        require_once "comuns/rodape.php";
    ?>
