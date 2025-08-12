<?php
require 'conexao.php'; // Arquivo de conexão com o banco de dados

if (isset($_GET['id'])) {
    $id_unidade = $_GET['id'];
    
    // Busca os dados da unidade
    $sql = "SELECT nome_escola, habilita, outros, independentes, portatil, lcd FROM Unidade_Escolar WHERE id_unidade = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_unidade);
    $stmt->execute();
    $stmt->bind_result($nome_escola, $habilita, $outros, $independentes, $portatil, $lcd);
    $stmt->fetch();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_unidade = $_POST['id_unidade'];
    $nome_escola = trim($_POST['nome_escola']);
    $habilita = isset($_POST['habilita']) ? 1 : 0; // Checkbox marcada = 1, desmarcada = 0
    $outros = isset($_POST['outros']) ? 1 : 0;
    $independentes = isset($_POST['independentes']) ? 1 : 0;
	$portatil = isset($_POST['portatil']) ? 1 : 0;
	$lcd = isset($_POST['lcd']) ? 1 : 0;
    
    // Atualiza os dados da unidade
    $sql = "UPDATE Unidade_Escolar SET nome_escola = ?, habilita = ?, outros = ?, independentes = ?, portatil = ?, lcd = ? WHERE id_unidade = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiiiii", $nome_escola, $habilita, $outros, $independentes, $portatil, $lcd, $id_unidade);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Unidade atualizada com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao atualizar unidade: " . $stmt->error . "</div>";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Unidade Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Unidade Escolar</h2>
        <form method="POST">
            <input type="hidden" name="id_unidade" value="<?php echo htmlspecialchars($id_unidade); ?>">
            
            <div class="mb-3">
                <label class="form-label">Nome da Escola:</label>
                <input type="text" name="nome_escola" class="form-control" value="<?php echo htmlspecialchars($nome_escola); ?>" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="habilita" class="form-check-input" id="habilita" <?php echo ($habilita ? 'checked' : ''); ?>>
                <label class="form-check-label" for="habilita">Sala Google</label>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="outros" class="form-check-input" id="outros" <?php echo ($outros ? 'checked' : ''); ?>>
                <label class="form-check-label" for="outros">Sala interativa</label>
            </div>
			
			<div class="mb-3 form-check">
                <input type="checkbox" name="portatil" class="form-check-input" id="portatil" <?php echo ($portatil ? 'checked' : ''); ?>>
                <label class="form-check-label" for="portatil">Kit Lousa Portátil</label>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="independentes" class="form-check-input" id="independentes" <?php echo ($independentes ? 'checked' : ''); ?>>
                <label class="form-check-label" for="independentes">Independentes</label>
            </div>
			<div class="mb-3 form-check">
                <input type="checkbox" name="lcd" class="form-check-input" id="lcd" <?php echo ($lcd ? 'checked' : ''); ?>>
                <label class="form-check-label" for="lcd">Kit Lousa LCD</label>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="home.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
