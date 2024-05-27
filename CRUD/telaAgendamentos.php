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
    <title>Agendamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>

.ModalSideBar{
width: 300px;
}


</style>
</head>
<body>
    <div class="container my-4">
    <h1 class="text-center">Área de Agendamentos</h1>
        <div class="row my-4">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Agendamentos</div>
                    <div class="card-body">
                        <h5 class="card-title">Número de Agendamentos:</h5>
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
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $nomes = ["Ana", "Bruno", "Carlos", "Diana", "Eduardo"];
                        $descricoes = ["Processo", "Outro", "Processo contra Fulano", "Processo contra ciclano", "10 mil do Tio Paulo"];
                        
                        for ($i = 0; $i < 5; $i++) {
                            $nome = $nomes[array_rand($nomes)];
                            $data = date("d/m/Y", strtotime("+".rand(0, 30)." days"));
                            $hora = rand(8, 17) . ":" . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
                            $descricao = $descricoes[array_rand($descricoes)];
                            echo "<tr>
                                    <td>{$nome}</td>
                                    <td>{$data}</td>
                                    <td>{$hora}</td>
                                    <td>{$descricao}</td>
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
