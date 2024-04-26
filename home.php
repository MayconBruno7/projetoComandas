<?php

require_once "helpers/protectUser.php";
require_once "comuns/cabecalho.php";
require_once "helpers/Formulario.php";
require_once "library/Database.php";


?>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-lg-10">
            <div class="row shadow-lg option-home back-white border-1 mt-4">
                <?php if (isset($_SESSION['userId']) && ($_SESSION['userNivel'] == 1)) : ?>

                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mt-4">
                        <div class="card h-100">
                            <a href="produtos.php" class="btn hvr-pulse btn-lg img">
                                <div class="card-body text-center">
                                    <p class="img text-center">
                                        <h5 class="card-title">Produtos</h5>
                                        <i class="bi bi-shop text-warning"></i>
                                    </p>
                                </div>
                            </a>    
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mt-4">
                        <div class="card h-100">
                            <a href="listaComanda.php" class="btn hvr-pulse btn-lg img">
                                <div class="card-body text-center">
                                    <p class="img text-center">
                                        <h5 class="card-title">Comandas</h5>
                                        <i class="bi bi-cart-plus text-warning"></i>
                                    </p>
                                </div>
                            </a> 
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mt-4">
                        <div class="card h-100">
                            <a href="listaUsuario.php" class="btn hvr-pulse btn-lg img">
                                <div class="card-body text-center">
                                    <p class="img text-center">
                                        <h5 class="card-title">Usuarios</h5>
                                        <i class="bi bi-person-fill text-warning"></i>
                                    </p>
                                </div>
                            </a> 
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mt-4">
                        <div class="card h-100">
                            <a href="Relatorios.php" class="btn hvr-pulse btn-lg img">
                                <div class="card-body text-center">
                                    <p class="img text-center">
                                        <h5 class="card-title">Relatórios</h5>
                                        <i class="bi bi-receipt text-warning"></i>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mt-4">
                        <div class="card h-100">
                            <a href="listaProdutoCategoria.php" class="btn hvr-pulse btn-lg img">
                                <div class="card-body text-center">
                                    <p class="img text-center">
                                        <h5 class="card-title">Categoria Produtos</h5>
                                        <i class="bi bi-list-ul text-warning"></i>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>

                    
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mt-4">
                        <div class="card h-100">
                            <a href="listaProduto.php" class="btn hvr-pulse btn-lg img">
                                <div class="card-body text-center">
                                    <p class="img text-center">
                                        <h5 class="card-title">Produtos/Serviços</h5>
                                        <i class="bi bi-collection text-warning"></i>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>

                                 
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mt-4">
                        <div class="card h-100">
                            <a href="listaMesa.php" class="btn hvr-pulse btn-lg img">
                                <div class="card-body text-center">
                                    <p class="img text-center">
                                        <h5 class="card-title">Mesas</h5>
                                        <i class="bi bi-menu-up text-warning"></i>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mt-4">
                        <div class="card h-100">
                            <a href="listaFormaPagamento.php" class="btn hvr-pulse btn-lg img">
                                <div class="card-body text-center">
                                    <p class="img text-center">
                                        <h5 class="card-title">Espécies Moeda</h5>
                                        <i class="bi bi-cash-coin text-warning"></i>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>

                <?php elseif (!isset($_SESSION['userNome'])) : ?>

                <?php else : ?>

                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mt-4">
                        <div class="card h-100">
                            <a href="produtos.php" class="btn hvr-pulse btn-lg img">
                                <div class="card-body text-center">
                                    <p class="img text-center">
                                        <h5 class="card-title">Produtos</h5>
                                        <i class="bi bi-shop text-warning"></i>
                                    </p>
                                </div>
                            </a>    
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mt-4">
                        <div class="card h-100">
                            <a href="listaComanda.php" class="btn hvr-pulse btn-lg img">
                                <div class="card-body text-center">
                                    <p class="img text-center">
                                        <h5 class="card-title">Comandas</h5>
                                        <i class="bi bi-cart-plus text-warning"></i>
                                    </p>
                                </div>
                            </a> 
                        </div>
                    </div>


                <?php endif; ?>
            </div>
        </div>
    </div>
</div>