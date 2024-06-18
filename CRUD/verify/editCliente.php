<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

require '../conexao.php';

if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM clientes WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $dados_cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dados_cliente) {
        $nome = $dados_cliente['nome'];
        $telefone = $dados_cliente['telefone'];
        $email = $dados_cliente['email'];
        $cpf = $dados_cliente['cpf'];
    } else {
        header('Location: ../telaClientes.php');
        exit;
    }
} else {
    header('Location: ../telaClientes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];

    if (empty($nome) || empty($telefone) || empty($email) || empty($cpf)) {
        header("Location: editCliente.php?id=$id&error=campos_vazios");
        exit();
    }

    if (strlen($telefone) != 11 || strlen($cpf) != 11) {
        header("Location: editCliente.php?id=$id&error=comprimento_invalido");
        exit();
    }

    $sql = "UPDATE clientes SET nome = :nome, telefone = :telefone, email = :email, cpf = :cpf WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':telefone', $telefone);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':cpf', $cpf);
    $stmt->bindValue(':id', $id);

    if ($stmt->execute()) {
        header("Location: ../telaClientes.php?sucesso=atualizacao_realizada");
        exit();
    } else {
        header("Location: editCliente.php?id=$id&error=atualizacao_falhou");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dados do Cliente</title>
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
                    <form method="POST" action="editCliente.php?id=<?php echo $id; ?>" data-parsley-validate>
                        <h3 class="text-center mb-4">Editar Dados do Cliente</h3>
                        <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'comprimento_invalido') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Telefone e CPF devem ter 11 caracteres!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            } elseif ($_GET['error'] == 'atualizacao_falhou') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Erro ao atualizar dados do cliente. Tente novamente.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            } elseif ($_GET['error'] == 'campos_vazios') {
                                echo '<div class="d-flex m-3 alert alert-danger alert-dismissible fade show" role="alert">
                                Todos os campos devem ser preenchidos!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            }
                        }
                        ?>
                        <div class="mb-3">
                            <label class="fs-6" for="nome">Nome</label><span>*</span>
                            <input class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" type="text" placeholder="Nome" required>
                        </div>
                        <div class="mb-3">
                            <label class="fs-6" for="telefone">Telefone</label><span>*</span>
                            <input class="form-control" id="telefone" name="telefone" maxlength="11" minlength="11" type="text" value="<?php echo $telefone; ?>" placeholder="Telefone com DDD" required>
                        </div>
                        <div class="mb-3">
                            <label class="fs-6" for="email">Email</label><span>*</span>
                            <input class="form-control" id="email" name="email" value="<?php echo $email; ?>" type="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label class="fs-6" for="cpf">CPF</label><span>*</span>
                            <input class="form-control" id="cpf" name="cpf" maxlength="11" minlength="11" value="<?php echo $cpf; ?>" type="text" placeholder="000.000.000-00" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <input class="btn btn-primary" type="submit" value="Atualizar dados" name="update">
                        </div>
                    </form>
                </div>
                <button class="btn btn-secondary mt-2"><a href="../telaClientes.php" class="text-white text-decoration-none">Voltar para a lista de clientes</a></button>
            </div>
        </div>
    </div>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/parsleyjs/dist/parsley.min.js"></script>
    <script src="../node_modules/parsleyjs/dist/i18n/pt-br.js"></script>
    <link rel="stylesheet" href="../node_modules/parsleyjs/src/parsley.css">
</body>
</html>
