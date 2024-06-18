<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
require 'header.php';
require 'conexao.php';
?>
</head>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
</head>
<body class="h-100">
    <div class="container my-4">
        <h1 class="py-2">Página Inicial</h1>
        <h1 class="text-center">Seja bem-vindo, <?php echo $_SESSION['usuario']; ?></h1>
        <hr class="m-4">
        <div class="row my-4">
            <div class="col-md-6">
                <div class="card text-white text-center bg-primary mb-3">
                    <div class="card-header">Clientes</div>
                    <div class="card-body">
                        <h5 class="card-title">Número de Clientes: <?php   
                            $sql = "SELECT COUNT(*) AS total_clientes FROM clientes";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total_clientes'];
                            ?></h5>
                        <p class="card-text"> 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white text-center bg-success mb-3">
                    <div class="card-header">Agendamentos</div>
                    <div class="card-body">
                        <h5 class="card-title">Número de Agendamentos: <?php
                            $sql = "SELECT COUNT(*) AS total_agenda FROM agendamentos";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total_agenda'];
                            ?></h5>
                        <p class="card-text">
                           
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4">
                <h2 class="m-1 p-1 mb-3">Relatório:</h2>
                <table class="table table-striped m-1">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Quant. Agendamentos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "
                            SELECT clientes.nome, COUNT(agendamentos.id) AS total_agendamentos
                            FROM clientes 
                            JOIN agendamentos ON clientes.id = agendamentos.clientes_id
                            GROUP BY clientes.nome
                            ORDER BY total_agendamentos DESC";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($resultado as $linha) {
                            echo '<tr>';
                            echo '<td>' . $linha['nome'] . '</td>';
                            echo '<td>' . $linha['total_agendamentos'] . '</td>';
                            echo '</tr>';
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
<?php require 'footer.php';?>

