<?php

    require_once "helpers/protectNivel.php";

    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();

    try {

        $imagem = $_POST['excluirImagem'];
        $upload = true;

        if ( $_POST['excluirImagem'] != $_FILES['imagem']['name'] and $_FILES['imagem']['name'] != "") {
        
            //lista de tipos de arquivos permitidos
            $tiposPermitidos =  array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');
            
            $tamanhoPermitido   = 1024 * 1024 * 5;                                          // 5mb //tamanho máximo (em bytes)
            $imagem             = Funcoes::gerarNomeAleatorio($_FILES['imagem']['name']);   // nome original do arquivo no computador do usuario
            $imagemType         = $_FILES['imagem']['type'];                                // o tipo do arquivo
            $imagemSize         = $_FILES['imagem']['size'];                                // o tamanho do arquivo
            $imagemTemp         = $_FILES['imagem']['tmp_name'];                            // o nome temporario do arquivo
            $imagemError        = $_FILES['imagem']['error'];                               // codigos de possiveis erros na imagem
            $msgError           = "";

            if ($imagemError === 0) {

                $upload = false;

                //veririca o tipo de arquivo enviado
                if (array_search($imagemType, $tiposPermitidos) === false) {
                    $msgError = "O tipo de arquivo enviado é inválido!";
                } else if ($imagemSize > $tamanhoPermitido) { //veririca o tamanho doa rquivo enviado
                    $msgError = "O tamanho do arquivo enviado é inválido!";
                } else { // não houve error, move o arquivo

                    $imagem = Funcoes::gerarNomeAleatorio($imagem);
                    $upload = move_uploaded_file($imagemTemp, 'uploads/produto/' . $imagem);

                    if (!$upload) {
                        $msgError = "Houve uma falha ao realizar o uploud da imagem!";
                    } else {
                        // unlink, ele excluí a imagem fisicamente no servidor
                        if (file_exists('uploads/produto/' . $_POST['excluirImagem'])) {
                            unlink('uploads/produto/' . $_POST['excluirImagem']);
                        }
                    }
                }
            }
        }

        if ($upload) {

            $custoTotalEstoque += ($_POST['QTD_ESTOQUE']) * ($_POST['PRECO_FABRICA']);

            $result = $db->dbUpdate("UPDATE produto
                                    SET descricao = ?, caracteristicas = ?, QTD_ESTOQUE = ?, CUSTO_TOTAL_ESTOQUE = ?, VALOR_UNITARIO = ?, STATUS_PRODUTO = ?, imagem = ?, ID_PRODUTO_CATEGORIA = ?, LOTE = ?
                                    WHERE ID_PRODUTOS = ?",
                                    [
                                        $_POST['descricao'],
                                        $_POST['caracteristicas'],
                                        Funcoes::strDecimais($_POST['QTD_ESTOQUE']),
                                        $custoTotalEstoque,
                                        Funcoes::strDecimais($_POST['VALOR_UNITARIO']),
                                        $_POST['STATUS_PRODUTO'],
                                        $imagem,
                                        $_POST['ID_PRODUTO_CATEGORIA'],
                                        $_POST['LOTE'],
                                        $_POST['id']
                                    ]);
            
            if ($result) {
                return header("Location: listaProduto.php?msgSucesso=Registro alterado com sucesso.");
            } else {
                return header("Location: listaProduto.php?msgError=Falha ao tentar alterar o registro.");
            }

        } else {
            return header("Location: listaProduto.php?msgError=" . $msgError);
        }

    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }