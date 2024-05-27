<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
require 'header.php';
require 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>

.ModalSideBar{
width: 300px;
}


</style>
</head>
<body>
    <div class="container my-4">
    <h1 class="text-center">Área de Clientes</h1>
        <div class="row my-4">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Clientes</div>
                    <div class="card-body">
                        <h5 class="card-title">Número de Clientes:</h5>
                        <p class="card-text"><?php echo rand(50, 200); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>CPF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $nomes = ["Ana", "Bruno", "Carlos", "Diana", "Eduardo"];
                        $sobrenomes = ["Silva", "Santos", "Oliveira", "Pereira", "Costa"];
                        $dominios = ["example.com", "test.com", "mail.com", "domain.com"];
                        
                        function gerarTelefone() {
                            return sprintf("(%02d) %05d-%04d", rand(10, 99), rand(10000, 99999), rand(1000, 9999));
                        }

                        function gerarCPF() {
                            return sprintf("%03d.%03d.%03d-%02d", rand(100, 999), rand(100, 999), rand(100, 999), rand(10, 99));
                        }

                        for ($i = 0; $i < 10; $i++) {
                            $nome = $nomes[array_rand($nomes)] . " " . $sobrenomes[array_rand($sobrenomes)];
                            $telefone = gerarTelefone();
                            $email = strtolower(str_replace(" ", ".", $nome)) . "@" . $dominios[array_rand($dominios)];
                            $cpf = gerarCPF();
                            echo "<tr>
                                    <td>{$nome}</td>
                                    <td>{$telefone}</td>
                                    <td>{$email}</td>
                                    <td>{$cpf}</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
