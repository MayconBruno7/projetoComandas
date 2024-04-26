<?php

    require_once "helpers/protectNivel.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $dataInicial = $_POST["data_inicial"];
        $dataFinal = $_POST["data_final"];

        $pdo = new PDO('mysql:host=localhost;dbname=comandas', 'root', '');

        $sql = "SELECT
                ID_Produto,
                Nome_Produto,
                Quantidade_Vendida,
                CAST(REPLACE(Valor_Item, '.', ',') AS DECIMAL(15,2)) AS Valor_Item,
                CAST(REPLACE(Total_Vendido, '.', ',') AS DECIMAL(15,2)) AS Total_Vendido
            FROM(
                SELECT 
                    ic.PRODUTOS_ID_PRODUTOS as ID_Produto,
                    p.descricao as Nome_Produto,
                    SUM(ic.QUANTIDADE) as Quantidade_Vendida,
                    ic.VALOR_ITEM as Valor_Item,
                    ic.VALOR_ITEM * SUM(ic.QUANTIDADE) as Total_Vendido
                FROM itens_comanda ic
                LEFT JOIN produto p ON (p.ID_PRODUTOS = ic.PRODUTOS_ID_PRODUTOS)
                LEFT JOIN comanda c ON (c.ID_COMANDA = ic.COMANDA_ID_COMANDA)
                WHERE
                    c.SITUACAO_COMANDA = 2
                AND
                    c.DATA_FECHAMENTO BETWEEN :data_inicial AND :data_final
                GROUP BY 1, 2
            ) as codigo
            
            ORDER BY 3 DESC";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':data_inicial', $dataInicial, PDO::PARAM_STR);
        $stmt->bindParam(':data_final', $dataFinal, PDO::PARAM_STR);

        $stmt->execute();

?>

    <table align="center">
        <thead>
            <tr>
                <th>ID Produto</th>
                <th>Nome Produto</th>
                <th>Quantidade Vendida</th>
                <th>Valor Item</th>
                <th>Total Vendido</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr class="linha">
                    <td><?php echo $row['ID_Produto']; ?></td>
                    <td><?php echo $row['Nome_Produto']; ?></td>
                    <td><?php echo $row['Quantidade_Vendida']; ?></td>
                    <td><?php echo $row['Valor_Item']; ?></td>
                    <td><?php echo $row['Total_Vendido']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
        $pdo = null; } 
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