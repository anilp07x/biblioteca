<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Listar Livros</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Inserir Livros</a></li>
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
                            <form class="form-valide" method="post">
                                <div class="container" style="max-width: 600px;">
                                <?php
                                    // Receber os dados do formulário
                                    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);    
                                        // Acessa o IF quando o usuário clicar no botão cadastrar
                                    if(!empty($dados['enviar'])){
                                        //var_dump($dados);

                                        // Criar a QUERY para cadastrar no banco de dados
                                        $query_usuario = "INSERT INTO livros (nome, isbn, id_autor, id_categoria, edicao, ano) VALUES (:nome, :isbn, :autor, :categoria, :edicao, :ano)";

                                        // Preparar a QUERY
                                        $cad_usuario = $conn->prepare($query_usuario);

                                        // Substituir o link pelo valor que vem do formulário
                                        $cad_usuario->bindParam(':nome', $dados['nome']);
                                        $cad_usuario->bindParam(':isbn', $dados['isbn']);
                                        $cad_usuario->bindParam(':autor', $dados['autor']);
                                        $cad_usuario->bindParam(':categoria', $dados['categoria']);
                                        $cad_usuario->bindParam(':edicao', $dados['edicao']);
                                        $cad_usuario->bindParam(':ano', $dados['ano']);

                                        // Executar a QUERY
                                        $cad_usuario->execute();

                                        // Acessa o IF quando cadastrar o registro no banco de dados
                                        if($cad_usuario->rowCount()){
                                            // Criar a mensagem e atribuir para variável global
                                            echo "<p style='color: green;'>Livro cadastrado com sucesso!</p>";
                                        header("Location: livros.php");
                                        }else{
                                            echo "<p style='color: #f00;'>Erro: Livro não cadastrado!</p>";
                                        }
                                    }


                                ?>
                                <h4 class="card-title">Inserir Livro | <a href="livros.php">Listar Livros</a></h4>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <input type="text" class="form-control" id="val-username" name="nome" placeholder="Nome do livro">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <input type="text" class="form-control" id="val-username" name="isbn" placeholder="ISBN">
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <select class="form-control" id="val-skill" name="autor">
                                                <option>Escolher Autor</option>
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
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['nome'] ?></option>
                                                <?php
                                                    }
                                                }
                                                
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <select class="form-control" id="val-skill" name="categoria">
                                                <option value="">Escolher Categoria</option>
                                                <?php

                                                $query_lista = "SELECT * FROM categoria ";

                                                // Preparar a QUERY
                                                $result_lista = $conn->prepare($query_lista);

                                                // Executar a QUERY
                                                $result_lista->execute();

                                                if(($result_lista) and ($result_lista->rowCount() != 0)){

                                                    // Ler os registro retornado do banco de dados
                                                    while($row_0 = $result_lista->fetch(PDO::FETCH_ASSOC)){

                                                ?>
                                                <option value="<?= $row_0['id_categoria'] ?>"><?= $row_0['nome_categoria'] ?></option>
                                                <?php
                                                    }
                                                }
                                                
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <input type="number" class="form-control" id="val-username" name="edicao" placeholder="Edição">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <input type="number" class="form-control" id="val-username" name="ano" placeholder="Ano">
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