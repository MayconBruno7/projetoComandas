<?php

    require_once "helpers/protectNivel.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $dataInicial = $_POST["data_inicial"];
        $dataFinal = $_POST["data_final"];

        $pdo = new PDO('mysql:host=localhost;dbname=comandas', 'root', '');

        $sql = "SELECT 
                    Desc_Categoria,
                    cast(qtdd_total AS DECIMAL(15,2)) AS qtdd_total,
                    cast(Total_Vendido AS DECIMAL(15,2)) AS Total_Vendido

                FROM(
                    SELECT
                        coalesce(pc.DESCRICAO_CATEGORIA, 'SEM CATEGORIA') AS Desc_Categoria,
                        SUM(ic.QUANTIDADE) AS qtdd_total,
                        SUM(ic.VALOR_ITEM) * SUM(ic.VALOR_ITEM) AS Total_Vendido 

                    FROM itens_comanda ic
                    LEFT JOIN comanda c ON (c.ID_COMANDA = ic.COMANDA_ID_COMANDA)
                    LEFT JOIN produto p ON (p.ID_PRODUTOS = ic.PRODUTOS_ID_PRODUTOS)
                    LEFT JOIN produto_categoria pc ON (pc.ID_CATEGORIA = p.ID_PRODUTO_CATEGORIA)

                WHERE
                    c.SITUACAO_COMANDA = 2
                AND
                    c.DATA_FECHAMENTO BETWEEN :data_inicial AND :data_final
        
                GROUP BY 1
            ) AS codigo

            ORDER BY 3 desc";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':data_inicial', $dataInicial, PDO::PARAM_STR);
        $stmt->bindParam(':data_final', $dataFinal, PDO::PARAM_STR);

        $stmt->execute();

?>

    <table align="center">
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Quantidade Vendida</th>
                <th>Valor Vendido</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr class="linha">
                    <td><?php echo $row['Desc_Categoria']; ?></td>
                    <td><?php echo $row['qtdd_total']; ?></td>
                    <td><?php echo $row['Total_Vendido']; ?></td>
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