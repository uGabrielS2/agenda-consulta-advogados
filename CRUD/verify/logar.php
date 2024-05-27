<?php
session_start();

if (isset($_SESSION["usuario"])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['usuario']) && !empty($_POST['usuario']) && isset($_POST['senha']) && !empty($_POST['senha'])) {
    require '../conexao.php';

    $usuario = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);

    $sql = 'SELECT * FROM adms WHERE usuario = :usuario AND senha = :senha';
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':usuario', $usuario);
    $stmt->bindValue(':senha', $senha);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $dado = $stmt->fetch();
        $_SESSION['id'] = $dado['id'];
        $_SESSION['usuario'] = $dado['usuario'];
        header('Location: ../index.php');
        exit();
    } else {
        header('Location: ../login.php?error=credenciais_invalidas');
        exit();
    }
}
?>
