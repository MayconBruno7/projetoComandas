<?php

    // Verifica se o método da requisição é POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Conecta ao banco de dados (substitua com suas próprias credenciais)
        $conexao = new PDO("mysql:host=localhost;dbname=restaurante", "root", "");

        // Obtém os dados da requisição
        $idMesa = $_POST['idMesa'];
        $novaSituacao = $_POST['novaSituacao'];

        // Atualiza a situação da mesa no banco de dados
        $stmt = $conexao->prepare("UPDATE mesas SET SITUACAO_MESA = :novaSituacao WHERE ID_MESA = :idMesa");
        $stmt->bindParam(':novaSituacao', $novaSituacao, PDO::PARAM_INT);
        $stmt->bindParam(':idMesa', $idMesa, PDO::PARAM_INT);

        try {
            $stmt->execute();
            echo "Situação da mesa atualizada com sucesso!";
        } catch (PDOException $e) {
            // Trate erros de execução do SQL conforme necessário
            echo "Erro ao atualizar a situação da mesa: " . $e->getMessage();
        }
    } else {
        // Responde com um erro se a requisição não for do tipo POST
        header("HTTP/1.1 405 Method Not Allowed");
        echo "Método não permitido. Esta página aceita apenas requisições POST.";
    }
?>
