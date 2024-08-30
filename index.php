<?php

session_start(); // Iniciar a sessão

// Limpara o buffer de redirecionamento
ob_start();

// Incluir o arquivo com a conexão com banco de dados
include_once 'config/conn.php';




?>
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Biblioteca ISPAJ</title>
    <link href="css/style.css" rel="stylesheet">
    
</head>

<body class="h-100">
    

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="index.html"> <h4>Biblioteca - ISPAJ</h4></a>
                                <?php
                                    // Receber os dados do formulário
                                    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                                    // Acessa o IF quando o usuário clicou no botão "Acessar" do formulário
                                    if (!empty($dados['enviar'])) {
                                        //var_dump($dados);

                                        // QUERY para recuperar o usuário do banco de dados
                                        $query_usuario = "SELECT id_user, nome, email, palavra_passe 
                                                    FROM users
                                                    WHERE email =:email
                                                    LIMIT 1";

                                        // Preparar a QUERY
                                        $result_usuario = $conn->prepare($query_usuario);

                                        // Substitui o link ":usuario" pelo valor que vem do formulário
                                        $result_usuario->bindParam(':email', $dados['email']);

                                        // Executar a QUERY
                                        $result_usuario->execute();

                                        // Acessa o IF quando encontrou usuário no banco de dados
                                        if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
                                            // Ler o resultado retornado do banco de dados
                                            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                                            //var_dump($row_usuario);

                                            // Verificar se a senha digitada pelo usuário no formulário é igual a senha salva no banco de dados
                                            if (password_verify($dados['palavra_passe'], $row_usuario['palavra_passe'])) {
                                                // O JWT é divido em três partes separadas por ponto ".": um header, um payload e uma signature

                                                // Header indica o tipo do token "JWT", e o algoritmo utilizado "HS256"
                                                $header = [
                                                    'alg' => 'HS256',
                                                    'typ' => 'JWT'
                                                    ];
                                                //var_dump($header);

                                                // Converter o array em objeto
                                                $header = json_encode($header);
                                                //var_dump($header);

                                                // Codificar dados em base64
                                                $header = base64_encode($header);

                                                // Imprimir o header
                                                //var_dump($header);

                                                // O payload é o corpo do JWT, recebe as informações que precisa armazenar
                                                // iss - O domínio da aplicação que gera o token
                                                // aud - Define o domínio que pode usar o token
                                                // exp - Data de vencimento do token
                                                // 7 days; 24 hours; 60 mins; 60secs
                                                $duracao = time() + (7 * 24 * 60 * 60);
                                                // 5 segundos
                                                // $duracao = time() + (5);

                                                $payload = [
                                                    /*'iss' => 'localhost',
                                                    'aud' => 'localhost',*/
                                                    'exp' => $duracao,
                                                    'id' => $row_usuario['id_user'],
                                                    'nome' => $row_usuario['nome'],
                                                    'email' => $row_usuario['email']
                                                ];

                                                // Converter o array em objeto
                                                $payload = json_encode($payload);
                                                //var_dump($payload);

                                                // Codificar dados em base64
                                                $payload = base64_encode($payload);

                                                // Imprimir o payload
                                                //var_dump($payload);

                                                // O signature é a assinatura. 
                                                // Chave secreta e única
                                                $chave = "DGBU85S46H9M5W4X6OD7";
                                                
                                                // Pegar o header e o payload e codificar com o algoritmo sha256, junto com a chave
                                                // Gera um valor de hash com chave usando o método HMAC
                                                $signature = hash_hmac('sha256', "$header.$payload", $chave, true);

                                                // Codificar dados em base64
                                                $signature = base64_encode($signature);

                                                // Imprimir o signature
                                                //var_dump($signature);

                                                // Imprimir o token
                                                //echo "Token: $header.$payload.$signature <br>";

                                                // Salvar o token em cookies
                                                // Cria o cookie com duração 7 dias
                                                setcookie('token', "$header.$payload.$signature", (time() + (7 * 24 * 60 * 60)));

                                                // Redirecionar o usuário para página dashboard
                                                header("Location: dashboard.php");

                                            } else {
                                                // Criar a mensagem de erro e atribuir para variável global "msg"
                                                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou senha inválida!</p>";
                                            }
                                        } else {
                                            // Criar a mensagem de erro e atribuir para variável global "msg"
                                            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou senha inválida!</p>";
                                        }
                                    }

                                    // Verificar se existe a variável global "msg" e acessa o IF
                                    if (isset($_SESSION['msg'])) {
                                        // Imprimir o valor da variável global "msg"
                                        echo $_SESSION['msg'];

                                        // Destruir a variável globar "msg"
                                        unset($_SESSION['msg']);
                                    }
                                ?>
                                
                                <form class="mt-5 mb-5 login-input" method="post">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="palavra_passe" class="form-control" placeholder="Password">
                                    </div>
                                    <input type="submit" name="enviar" class="btn login-form__btn submit w-100" value="Entrar">
                                </form>
                                <p class="mt-5 login-form__footer">Dont have account? <a href="page-register.html" class="text-primary">Sign Up</a> now</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>
</html>





