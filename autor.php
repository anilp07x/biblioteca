<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<div class="content-body">

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Livros</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Listagem de Autores | <a href="inserir_autor.php">Inserir Autor</a></h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

                                $query_listar = "SELECT * FROM autores ";
                
                                // Preparar a QUERY
                                $result_listar = $conn->prepare($query_listar);
                                
                                // Executar a QUERY
                                $result_listar->execute();

                                if(($result_listar) and ($result_listar->rowCount() != 0)){

                                    // Ler os registro retornado do banco de dados
                                    while($row = $result_listar->fetch(PDO::FETCH_ASSOC)){
                            
                            ?>
                                <tr>
                                    <td><?php echo $row['nome'] ?></td>
                                </tr>  
                                <?php
                                }
                            }else{
                                echo "Erro: Nenhum Autor encontrado!";
                            }
                            
                            ?>                       
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #/ container -->
</div>

<?php include 'inc/footer.php' ?>