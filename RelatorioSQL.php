<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os valores dos campos de entrada Rel_ProdutosVendidos.php
    $dataInicial = $_POST["data_inicial"];
    $dataFinal = $_POST["data_final"];

    var_dump($dataFinal, $dataInicial);

    // Conectar ao banco de dados (substitua pelos seus dados de conexão)
    $pdo = new PDO('mysql:host=localhost;dbname=restaurante', 'root', '');

    // Preparar a consulta SQL
    $sql = "SELECT 
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
ORDER BY 3 DESC";

    // Preparar a declaração SQL
    $stmt = $pdo->prepare($sql);

    // Bind dos parâmetros
    $stmt->bindParam(':data_inicial', $dataInicial, PDO::PARAM_STR);
    $stmt->bindParam(':data_final', $dataFinal, PDO::PARAM_STR);

    // Executar a consulta
    $stmt->execute();
    

    // Exibir resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
        echo "ID Produto: " . $row['ID_Produto'] . "<br>";
        echo "Nome Produto: " . $row['Nome_Produto'] . "<br>";
        echo "Valor Item: " . $row['Valor_Item'] . "<br>";
        echo "Quantidade Vendida: " . $row['Quantidade_Vendida'] . "<br>";
        echo "Total Vendido: " . $row['Total_Vendido'] . "<br>";
        echo "---------------------------<br>";
    }
    

    // Fechar a conexão
    $pdo = null;
}
?>
