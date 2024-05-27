<?php
if (isset($_POST['usuario']) && isset($_POST['senha']) && !empty($_POST['usuario']) && !empty($_POST['senha'])) {
    session_start();
    require '../conexao.php';

    $usuario = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);

    if (strlen($senha) < 6) {
        header('Location: ../cadastro.php?error=senha_curta');
        exit();
    }    

    $sql = "SELECT COUNT(*) FROM adms WHERE usuario = :usuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':usuario', $usuario);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        header('Location: ../cadastro.php?error=usuario_existente');
        exit();   
} 
    else {
        $sql = "INSERT INTO adms (usuario, senha) VALUES (:usuario, :senha)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':usuario', $usuario);
            $stmt->bindValue(':senha', $senha);
            $stmt->execute();
            header('Location: ../login.php');
            exit();
    }
}
?>
