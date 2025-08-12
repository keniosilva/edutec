<?php
session_start();
require 'conexao.php'; // Arquivo de conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_escola = trim($_POST['nome_escola']);
    $usuario = $_SESSION['user'] ?? 'desconhecido'; // Usuário logado ou 'desconhecido'

    // Verifica se a unidade já existe no banco de dados
    $sql_check = "SELECT id_unidade FROM Unidade_Escolar WHERE nome_escola = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $nome_escola);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    if ($stmt_check->num_rows > 0) {
        echo "<div class='alert alert-warning'>Essa unidade já está cadastrada!</div>";
    } else {
        // Insere a nova unidade se não existir
        $sql = "INSERT INTO Unidade_Escolar (nome_escola) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nome_escola);
    
        if ($stmt->execute()) {
            // Obtém o ID do último registro inserido
            $id_unidade = $stmt->insert_id;

            // Registra o log da operação
            $sql_log = "INSERT INTO log_sistema (tabela_afetada, acao, usuario) VALUES ('Unidade_Escolar', 'INSERT', ?)";
            $stmt_log = $conn->prepare($sql_log);
            $stmt_log->bind_param("s", $usuario);
            $stmt_log->execute();
            $stmt_log->close();

            echo "<div class='alert alert-success'>Unidade adicionada com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao adicionar unidade: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
    
    $stmt_check->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Unidade Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Adicionar Unidade Escolar</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nome da Escola:</label>
                <input type="text" name="nome_escola" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>
        <a href="home.php" class="btn btn-secondary mt-3">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
