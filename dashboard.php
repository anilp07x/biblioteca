
<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

    <div class="content-body">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="card gradient-1">
                        <div class="card-body">
                            <h3 class="card-title text-white">Livros</h3>
                            <div class="d-inline-block">
                            <?php

                                $query_listar = "SELECT * FROM livros ";

                                // Preparar a QUERY
                                $result_listar = $conn->prepare($query_listar);

                                // Executar a QUERY
                                $result_listar->execute();

                                if($cont = $result_listar->rowCount()){

                                ?>
                                <h2 class="text-white"><?= $cont ?></h2>
                                <?php } ?>
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-book"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <h3 class="card-title text-white">Ctegorias</h3>
                            <div class="d-inline-block">
                            <?php

                            $query_lista = "SELECT * FROM categoria ";

                            // Preparar a QUERY
                            $result_lista = $conn->prepare($query_lista);

                            // Executar a QUERY
                            $result_lista->execute();

                            if($cont_1 = $result_lista->rowCount()){

                            ?>
                            <h2 class="text-white"><?= $cont_1 ?></h2>
                            <?php } ?>
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-bug"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card gradient-3">
                        <div class="card-body">
                            <h3 class="card-title text-white">Autores</h3>
                            <div class="d-inline-block">
                            <?php

                                $query_list = "SELECT * FROM autores ";

                                // Preparar a QUERY
                                $result_list = $conn->prepare($query_list);

                                // Executar a QUERY
                                $result_list->execute();

                                if($cont_2 = $result_list->rowCount()){

                                ?>
                                <h2 class="text-white"><?= $cont_2 ?></h2>
                                <?php } ?>
                                
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>                   
    </div>

<?php include 'inc/footer.php' ?>