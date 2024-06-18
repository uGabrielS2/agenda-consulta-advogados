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
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($agendamento) {
        $sql = "DELETE FROM agendamentos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        if ($stmt->execute()) {
            header("Location: ../telaAgendamentos.php?sucesso=agendamento_deletado");
        } else {
            header("Location: ../telaAgendamentos.php?erro=erro_ao_deletar");
        }
    } else {
        header("Location: ../telaAgendamentos.php?erro=agendamento_nao_encontrado");
    }
} else {
    header("Location: ../telaAgendamentos.php?erro=id_nao_fornecido");
}
exit;
?>
