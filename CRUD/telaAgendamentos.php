<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
require 'header.php';
require 'conexao.php';
?>
<?php

$sql = "SELECT COUNT(*) AS total_agenda FROM agendamentos";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <script defer src="javascript/script1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php
    if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'cadastro_realizado') {
        echo '<div class="alert alert-success d-flex justify-content-center position-relative" role="alert" style="position: relative;">
        <div class="w-100 text-center">
        Agendamento realizado com sucesso!
        </div>
        <button type="button" class="btn-close position-absolute top-0 end-0 p-2 mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    elseif (isset($_GET['sucesso']) && $_GET['sucesso'] == 'atualizacao_realizada') {
        echo '<div class="alert alert-success d-flex justify-content-center position-relative" role="alert" style="position: relative;">
        <div class="w-100 text-center">
        Dados atualizados com sucesso!
        </div>
        <button type="button" class="btn-close position-absolute top-0 end-0 p-2 mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
?>
<div class="container my-4">
    <h1 class="text-center">Área de Agendamentos</h1>
    <div class="row my-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Agendamentos</div>
                <div class="card-body">
                    <h5 class="card-title">Número de Agendamentos: <?php echo $result['total_agenda']; ?></h5>
                </div>
            </div>
            <a class='btn btn-success btn-lg' href='verify/cadastrarAgendamentos.php'>Criar Agendamento
                <svg class="SvgIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                    <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
                </svg>
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped m-1">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Data</th>
                    <th scope="col">Advogado</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
            require 'conexao.php';

            $sql = "SELECT agendamentos.id, agendamentos.data, agendamentos.advogado, agendamentos.descricao,
                    clientes.nome AS cliente_nome
                    FROM agendamentos
                    INNER JOIN clientes ON agendamentos.clientes_id = clientes.id
                    ORDER BY agendamentos.id DESC";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $dados_agenda) {
                echo "<tr>";
                echo "<td>" . $dados_agenda['id'] . "</td>";
                echo "<td>" . $dados_agenda['data'] . "</td>";
                echo "<td>" . $dados_agenda['advogado'] . "</td>";
                echo "<td>" . $dados_agenda['descricao'] . "</td>";
                echo "<td>" . $dados_agenda['cliente_nome'] . "</td>";
                echo "<td>
                        <a class='btn btn-sm btn-primary' href='verify/editarAgendamento.php?id=" . $dados_agenda['id'] . "'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                            </svg>
                        </a>
                        <button type='button' class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#modalDelete' data-id='" . $dados_agenda['id'] . "'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3-fill' viewBox='0 0 16 16'>
                                <path d='M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5'/>
                            </svg>
                        </button>
                    </td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php require 'footer.php'; ?>

<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Certeza que deseja deletar este agendamento?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="confirmDeleteButton" class='btn btn-danger' href='#'>Sim, eu tenho</a>
            </div>
        </div>
    </div>
</div>
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

