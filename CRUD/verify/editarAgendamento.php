<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

require '../conexao.php';

if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM agendamentos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($agendamento) {
        $data = date('Y-m-d\TH:i', strtotime($agendamento['data']));
        $advogado = $agendamento['advogado'];
        $descricao = $agendamento['descricao'];
        $clientes_id = $agendamento['clientes_id'];
    } else {
        header('Location: ../telaAgendamentos.php');
        exit;
    }
} else {
    header('Location: ../telaAgendamentos.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    if (empty($_POST['data']) || empty($_POST['descricao']) || empty($_POST['id_cliente'])) {
        $error = "campos_vazios";
    } else {
        $data = $_POST['data'];
        $descricao = $_POST['descricao'];
        $clientes_id = $_POST['id_cliente'];

        $sql = "UPDATE agendamentos SET data = :data, descricao = :descricao, clientes_id = :clientes_id WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':clientes_id', $clientes_id);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header("Location: ../telaAgendamentos.php?sucesso=atualizacao_realizada");
            exit();
        } else {
            $error = "atualizacao_falhou";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
    <script defer src="script.js"></script>
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
                    <form method="POST" action="editarAgendamento.php?id=<?php echo $id; ?>" data-parsley-validate>
                        <h3 class="text-center mb-4">Editar Agendamento</h3>
                        <?php
                        if (isset($error)) {
                            if ($error == 'campos_vazios') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Erro, um ou mais campos estão vazios!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            } elseif ($error == 'atualizacao_falhou') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Erro ao atualizar agendamento. Tente novamente.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            }
                        }
                        ?>
                        <div class="mb-3">
                            <label class="fs-6" for="data">Data</label><span>*</span>
                            <input class="form-control" id="data" name="data" type="datetime-local" value="<?php echo $data; ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="fs-6" for="advogado">Advogado</label><span>*</span>
                            <input class="form-control" id="advogado" name="advogado" type="text" value="<?php echo $advogado; ?>" disabled="" placeholder="Advogado">
                        </div>
                        <div class="mb-2">
                            <label class="fs-6" for="descricao">Descrição</label><span>*</span>
                            <textarea class="form-control" id="descricao" name="descricao" maxlength="100" placeholder="Descrição" required><?php echo $descricao; ?></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="fs-6" for="id_cliente">Cliente</label><span>*</span>
                            <select class="form-control" id="id_cliente" name="id_cliente" required>
                                <option value="">Selecione um cliente</option>
                                <?php
                                $sql = "SELECT id, nome FROM clientes";
                                foreach ($conn->query($sql) as $linha) {
                                    $selected = ($linha['id'] == $clientes_id) ? 'selected' : '';
                                    echo '<option value="' . $linha['id'] . '" ' . $selected . '>' . $linha['nome'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <input class="btn btn-primary" type="submit" value="Atualizar dados" name="update">
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
