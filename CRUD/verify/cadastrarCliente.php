<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}
?>
<?php
require '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nome']) || empty($_POST['telefone']) || empty($_POST['email']) || empty($_POST['cpf'])) {
        header('Location: cadastrarCliente.php?error=campos_vazios');
        exit();
    }

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];

    if (strlen($telefone) != 11 || strlen($cpf) != 11) {
        header('Location: cadastrarCliente.php?error=comprimento_invalido');
        exit();
    }

    $sql = "SELECT COUNT(*) FROM clientes WHERE nome = :nome OR telefone = :telefone OR email = :email OR cpf = :cpf";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':telefone', $telefone);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':cpf', $cpf);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        header('Location: cadastrarCliente.php?error=repeticao');
        exit();
    }

    $sql = "INSERT INTO clientes (nome, telefone, email, cpf) VALUES (:nome, :telefone, :email, :cpf)";
    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':telefone', $telefone);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':cpf', $cpf);

    if ($stmt->execute()) {
        header("Location: ../telaClientes.php?sucesso=cadastro_realizado");
        exit();
    } else {
        header('Location: cadastrarCliente.php?error=atualizacao_falhou');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
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
                    <form method="POST" action="cadastrarCliente.php" data-parsley-validate>
                        <h3 class="text-center mb-4">Cadastro de Clientes</h3>
                        <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'campos_vazios') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Erro, um ou mais campos estão vazios!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            } elseif ($_GET['error'] == 'comprimento_invalido') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Erro, telefone e CPF não existem!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            } elseif ($_GET['error'] == 'repeticao') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Erro, já existe um cliente com estes dados cadastrado!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            } elseif ($_GET['error'] == 'atualizacao_falhou') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Erro ao cadastrar cliente. Tente novamente.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            }
                        }
                        ?>
                        <div class="mb-3">
                            <label class="fs-6" for="nome">Nome</label><span>*</span>
                            <input class="form-control" id="nome" name="nome" type="text" maxlength="100" placeholder="Nome" required>
                        </div>
                        <div class="mb-3">
                            <label class="fs-6" for="telefone">Telefone</label><span>*</span>
                            <input class="form-control" id="telefone" name="telefone" maxlength="11" minlength="11" type="text" placeholder="Telefone com DDD" required>
                        </div>
                        <div class="mb-3">
                            <label class="fs-6" for="email">Email</label><span>*</span>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label class="fs-6" for="cpf">CPF</label><span>*</span>
                            <input class="form-control" id="cpf" name="cpf" type="text" maxlength="11" minlength="11" placeholder="000.000.000-00" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <input class="btn btn-primary" type="submit" value="Cadastrar" name="submit">
                        </div>
                    </form>
                </div>
                <a href="../telaClientes.php" class="btn btn-secondary mt-3">Voltar para a lista de clientes</a>
            </div>
        </div>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/parsleyjs/dist/parsley.min.js"></script>
    <script src="../node_modules/parsleyjs/dist/i18n/pt-br.js"></script>
    <link rel="stylesheet" href="../node_modules/parsleyjs/src/parsley.css">
</body>
</html>
