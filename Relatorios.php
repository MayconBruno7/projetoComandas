<?php
    require_once "helpers/protectNivel.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    $dataAtual = date('Y-m-d');
?>

    <h2>Relatórios</h2>

    <table align="center" class='mt-3'>
        <tbody>
            <tr>
                <form id='datas' method="post" action="Rel_ProdutosVendidos.php">
                    <td>
                        Histórico de Produtos Vendidos   
                    </td>  
                    <td>
                        <label for="data_inicial">Data Inicial:</label>
                        <input type="date" id="data_inicial" name="data_inicial" value="<?php echo $dataAtual; ?>" required>

                        <label for="data_final">⠀⠀⠀Data Final:</label>
                        <input type="date" id="data_final" name="data_final" value="<?php echo $dataAtual; ?>" required>    
                    </td>
                    <td>   
                        <button type="submit" class='m-3'>
                            Confirmar
                        </button>
                    </td>
                </form>
            <tr>

            <tr>
                <form id='datas' method="post" action="Rel_CategoriasVendidas.php">
                    <td>
                        Histórico de Categorias Vendidas   
                    </td>  
                    <td>
                        <label for="data_inicial">Data Inicial:</label>
                        <input type="date" id="data_inicial" name="data_inicial" value="<?php echo $dataAtual; ?>" required>

                        <label for="data_final">⠀⠀⠀Data Final:</label>
                        <input type="date" id="data_final" name="data_final" value="<?php echo $dataAtual; ?>" required>    
                    </td>
                    <td>   
                    <button type="submit" class='m-3'>
                            Confirmar
                        </button>
                    </td>
                </form>
            <tr>
    
            <tr>
                <form id='datas' method="post" action="Rel_FormasPagamentos.php">
                    <td>
                        Formas de Pagamento pelo Período 
                    </td>  
                    <td>
                        <label for="data_inicial">Data Inicial:</label>
                        <input type="date" id="data_inicial" name="data_inicial" value="<?php echo $dataAtual; ?>" required>

                        <label for="data_final">⠀⠀⠀Data Final:</label>
                        <input type="date" id="data_final" name="data_final" value="<?php echo $dataAtual; ?>" required>    
                    </td>
                    <td>   
                    <button type="submit" class='m-3'>
                            Confirmar
                        </button>
                    </td>
                </form>
            <tr>
        </tbody>
    </table>


    <style type="text/css">

    h2,h1{
        text-align: center !important;
    }


    table{

        width: 90% !important;
    }

    td{
        border: 1px solid black !important;
        padding: 5px !important;
        text-align: center !important;
    }


    tbody tr:nth-child(odd){
        background-color: ghostwhite !important;
    }


    </style>

    <?php
        require_once "comuns/rodape.php";
    ?>