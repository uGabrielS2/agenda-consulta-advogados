<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

require '../conexao.php';

if (!empty($_GET['id'])) {
    
    $id = $_GET['id'];

        $sql = "SELECT COUNT(*) FROM agendamentos WHERE clientes_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $agendamentosCount = $stmt->fetchColumn();

        if ($agendamentosCount > 0) {
            header("Location: ../telaClientes.php?erro=cliente_tem_agendamentos");
            exit();
        } else {
            $sql = "DELETE FROM clientes WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            header("Location: ../telaClientes.php?sucesso=cliente_deletado");
            exit();
        }
} else {
    header("Location: ../telaClientes.php");
    exit;
}
?>
