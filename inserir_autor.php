<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Listar Autroes</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Inserir Autores</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">
                        <?php
                            // Receber os dados do formulário
                            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);    
                                // Acessa o IF quando o usuário clicar no botão cadastrar
                            if(!empty($dados['enviar'])){
                                //var_dump($dados);

                                // Criar a QUERY para cadastrar no banco de dados
                                $query_usuario = "INSERT INTO autores (nome) VALUES (:nome)";

                                // Preparar a QUERY
                                $cad_usuario = $conn->prepare($query_usuario);

                                // Substituir o link pelo valor que vem do formulário
                                $cad_usuario->bindParam(':nome', $dados['nome']);

                                // Executar a QUERY
                                $cad_usuario->execute();

                                // Acessa o IF quando cadastrar o registro no banco de dados
                                if($cad_usuario->rowCount()){
                                    // Criar a mensagem e atribuir para variável global
                                    echo "<p style='color: green;'>Autor cadastrado com sucesso!</p>";
                                header("Location: autor.php");
                                }else{
                                    echo "<p style='color: #f00;'>Erro: Autor não cadastrado!</p>";
                                }
                            }


                        ?>
                            <form method="post">
                                <div class="container" style="max-width: 600px;">
                                <h4 class="card-title">Inserir Autor | <a href="autor.php">Listar Autores</a></h4>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <input type="text" class="form-control" name="nome" placeholder="Nome do Autor">
                                        </div>
                                        <div class="col-lg-8 ">
                                                <input type="submit" class="btn btn-primary" value="Cadastrar" name="enviar">
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- #/ container -->
</div>

<?php include 'inc/footer.php' ?>