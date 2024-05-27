<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <script defer src="script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .form-container{
    max-width: 350px;
    padding: 1rem;
}
    body{
        background-image: url("assets/background.png");
        background-position: 55% 15%;
    }
    </style>
</head> 
<body>
    <div class="container-fluid" id="bodyForm">
        <div class="row justify-content-center align-items-center min-vh-100 ">
            <div class="col-sm-8 col-md-6 col-lg-3">
                <div id="tela" class="p-4 rounded shadow">
                    <form method="POST" class="validationCustom01" action="verify/verifyCadastrar.php" data-parsley-validate>
                    <h3 class="text-center mb-4">Fazer Cadastro</h3>
                    <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'usuario_existente') {
                                echo '<div class="alert alert-danger" role="alert">Usuário já existente! Tente outro nome de usuário.</div>';
                            } elseif ($_GET['error'] == 'senha_curta') {
                                echo '<div class="alert alert-danger" role="alert">A senha deve ter pelo menos 6 caracteres.</div>';
                            }
                        }
                        ?>
                        <div class="mb-3">
                          <label class="fs-6" for="usuario">Nome de usuário</label>
                            <input class="form-control" id="usuario" name="usuario" type="text" placeholder="Usuário" required> 
                        
                        </div>
                        <div class="mb-3">
                        <label class="fs-6" for="senha">Senha</label>
                            <input class="form-control" id="senha" name="senha" type="password" placeholder="Senha" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <input class="btn btn-primary" type="submit" value="Cadastrar" name="submit"> 
                            <div class="form-check">    
                                <input class="form-check-input" type="checkbox" id="mostrarSenha" onclick="msenha()">
                                <label class="form-check-label" for="mostrarSenha" id="bsenha">Mostrar senha</label>
                            </div>   
                    </form>
                </div>
              <a href="login.php">Já possui uma conta? Clique aqui</a> 
            </div> 
        </div>
    <script  src="node_modules/jquery/dist/jquery.min.js"></script>
    <script  src="node_modules/parsleyjs/dist/parsley.min.js"></script>
    <script  src="node_modules/parsleyjs/dist/i18n/pt-br.js"></script>
    <link rel="stylesheet" href="node_modules/parsleyjs/src/parsley.css">