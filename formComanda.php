<?php

    require_once "helpers/protectUser.php";
    require_once "helpers/Formulario.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();
    $dados = [];


    $aMesa = $db->dbSelect("SELECT * FROM mesas ORDER BY ID_MESA");
    
    if ($_GET['acao'] != "insert") {

        $dados = $db->dbSelect("SELECT * FROM comanda WHERE ID_COMANDA = ?", 'first', [$_GET['idComanda']]);
    }

    if (($_GET['acao'] == "delete") && $dados->DATA_FECHAMENTO === null) {
        return header("Location: listaComanda.php?msgError=Não é possível excluir uma comanda em abertos");
    }
?>

    <main class="container mt-5">
        <div class="row">
            <div class="col-10">
                <h2>Comandas<?= subTitulo($_GET['acao']) ?></h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaComanda.php" class="btn btn-outline-secondary btn-sm" title="Voltar">Voltar</a>
            </div>
        </div>

        <form class="g-3" action="<?= $_GET['acao'] ?>Comanda.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idComanda" value="<?= isset($dados->ID_COMANDA) ? $dados->ID_COMANDA : "" ?>">

            <div class="row">
                <div class="col-12">
                    <label for="DESCRICAO_COMANDA" class="form-label">Nome do Cliente</label>
                    <input type="text" class="form-control" name="DESCRICAO_COMANDA" 
                        id="DESCRICAO_COMANDA" placeholder="Nome do Cliente" maxlength="50"
                        value="<?= isset($dados->DESCRICAO_COMANDA) ? $dados->DESCRICAO_COMANDA : "" ?>">

                </div>
                
                <div class="col-6">
                    <label for="MESA_ID_MESA" class="form-label">Mesa</label>
                    <select name="MESA_ID_MESA" id="MESA_ID_MESA" class="form-control" required>
                        <option value=""  <?= isset($dados->MESA_ID_MESA) ? ($dados->MESA_ID_MESA == "" ? "selected" : "") : "" ?>>...</option>
                        <?php foreach ($aMesa as $MESA): ?>
                            <option <?= (isset($dados->MESA_ID_MESA) ? ($dados->MESA_ID_MESA == $MESA['ID_MESA'] ? 'selected' : '') : "") ?> 
                            value="<?= $MESA['ID_MESA'] ?>"><?= $MESA['ID_MESA'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
    
            </div>
            <?php if ($_GET['acao'] != "view"): /* botão gravar não é exibido na visualização dos dados */ ?>
                    <button type="submit" class="btn btn-primary btn-sm mt-3">Gravar</button>
            <?php endif; ?>

        </form>
    </main>

    <script>

        let mesas = document.getElementById('mesa');
        
    </script>