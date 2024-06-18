<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

require '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['data']) || empty($_POST['advogado']) || empty($_POST['descricao']) || empty($_POST['id_cliente'])) {
        header('Location: cadastrarAgendamentos.php?error=campos_vazios');
        exit();
    }

    $data = $_POST['data'];
    $advogado = $_POST['advogado'];
    $descricao = $_POST['descricao'];
    $clientes_id = $_POST['id_cliente'];

    $sql = "INSERT INTO agendamentos (data, advogado, descricao, clientes_id) VALUES (:data, :advogado, :descricao, :clientes_id)";
    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':data', $data);
    $stmt->bindValue(':advogado', $advogado);
    $stmt->bindValue(':descricao', $descricao);
    $stmt->bindValue(':clientes_id', $clientes_id);

    if ($stmt->execute()) {
        header("Location: ../telaAgendamentos.php?sucesso=cadastro_realizado");
        exit();
    } else {
        header('Location: cadastrarAgendamentos.php?error=atualizacao_falhou');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Agendamentos</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style/styleLogin.css">
</head>
<body>
    <div class="container-fluid" id="bodyForm">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-sm-8 col-md-6 col-lg-3">
                <div id="tela" class="p-4 rounded shadow">
                    <form method="POST" action="cadastrarAgendamentos.php" data-parsley-validate>
                        <h3 class="text-center mb-4">Cadastro de Agendamentos</h3>
                        <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'campos_vazios') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Erro, um ou mais campos estão vazios!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            } elseif ($_GET['error'] == 'atualizacao_falhou') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Erro ao cadastrar agendamento. Tente novamente.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            }
                        }
                        ?>
                        <div class="mb-2">
                            <label class="fs-6" for="data">Data</label><span>*</span>
                            <input class="form-control" id="data" name="data" type="datetime-local" placeholder="Data" required>
                        </div>
                        <div class="mb-2">
                            <label class="fs-6" for="advogado">Advogado</label><span>*</span>
                            <input class="form-control" id="advogado" name="advogado" value="Hugo Nathan Régis Barbosa" type="text" placeholder="Advogado" required>
                        </div>
                        <div class="mb-2">
                            <label class="fs-6" for="descricao">Descrição</label><span>*</span>
                            <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="fs-6" for="id_cliente">Cliente</label><span>*</span>
                            <select class="form-control" id="id_cliente" name="id_cliente" required>
                                <option value="">Selecione um cliente</option>
                                <?php
                                $sql = "SELECT id, nome FROM clientes";
                                foreach ($conn->query($sql) as $linha) {
                                    echo '<option value="' . $linha['id'] . '">' . $linha['nome'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <input class="btn btn-primary" type="submit" value="Cadastrar" name="submit">
                        </div>
                    </form>
                </div>
                <a href="../telaAgendamentos.php" class="btn btn-secondary mt-3">Voltar para a lista de agendamentos</a>
            </div>
        </div>
    </div>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/parsleyjs/dist/parsley.min.js"></script>
    <script src="../node_modules/parsleyjs/dist/i18n/pt-br.js"></script>
    <link rel="stylesheet" href="../node_modules/parsleyjs/src/parsley.css">
</body>
</html>
