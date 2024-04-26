<?php

    require_once "helpers/protectNivel.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $dataInicial = $_POST["data_inicial"];
        $dataFinal = $_POST["data_final"];

        $pdo = new PDO('mysql:host=localhost;dbname=comandas', 'root', '');

        $sql = "SELECT 
                    fp.DESCRICAO_FORMA_PAGAMENTO,
                    cast(SUM(fc.VALOR_PAGAMENTO) AS DECIMAL(15,2)) AS Total_Pagamento

                FROM fin_comanda fc
                LEFT JOIN comanda c ON (c.ID_COMANDA = fc.COMANDA_ID_COMANDA)
                LEFT JOIN formas_pagamento fp ON (fp.ID_FORMA_PAGAMENTO = fc.PAGAMENTO_ID_PAGAMENTO)

                WHERE 
                    c.SITUACAO_COMANDA = 2
                AND
                    c.DATA_FECHAMENTO BETWEEN :data_inicial AND :data_final
                    
                GROUP BY 1

                ORDER BY 2 desc";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':data_inicial', $dataInicial, PDO::PARAM_STR);
        $stmt->bindParam(':data_final', $dataFinal, PDO::PARAM_STR);

        $stmt->execute();

?>

    <table align="center">
        <thead>
            <tr>
                <th>Forma de Pagamento</th>
                <th>Valor Vendido</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr class="linha">
                    <td><?php echo $row['DESCRICAO_FORMA_PAGAMENTO']; ?></td>
                    <td><?php echo $row['Total_Pagamento']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
        $pdo = null;
    }
    ?>

    <style type="text/css">

        h2,h1{
            text-align: center !important;
        }

        table{
            width: 90% !important;
        }

        th,td{
            border: 1px solid black !important;
            padding: 5px !important;
            text-align: center !important;
        }

        tbody tr:nth-child(odd){
            background-color: ghostwhite !important;
        }
        

    </style>