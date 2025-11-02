<?php
require_once 'auth_check.php';
require_once 'header.php';
require_once 'conexao.php';

$id_unidade = null;
$nome_escola = '';
$id_cidade = '';
$habilita = 0;
$outros = 0;
$independentes = 0;
$portatil = 0;
$lcd = 0;

// Obter informações do usuário logado
$user = getLoggedUser();
$user_city_id = $user['id_cidade'] ?? 1;
$is_admin = isAdmin();

// Processa o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_unidade = $_POST['id_unidade'];
    $nome_escola = trim($_POST['nome_escola']);
    $id_cidade = $_POST['id_cidade'];
    $habilita = isset($_POST['habilita']) ? 1 : 0;
    $outros = isset($_POST['outros']) ? 1 : 0;
    $independentes = isset($_POST['independentes']) ? 1 : 0;
    $portatil = isset($_POST['portatil']) ? 1 : 0;
    $lcd = isset($_POST['lcd']) ? 1 : 0;
    
    // Atualiza os dados da unidade
    $sql = "UPDATE unidade_escolar SET nome_escola = ?, id_cidade = ?, habilita = ?, outros = ?, independentes = ?, portatil = ?, lcd = ? WHERE id_unidade = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiiiiii", $nome_escola, $id_cidade, $habilita, $outros, $independentes, $portatil, $lcd, $id_unidade);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Unidade atualizada com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao atualizar unidade: " . $stmt->error . "</div>";
    }
    $stmt->close();
} else if (isset($_GET['id'])) {
    $id_unidade = $_GET['id'];
    
    // Busca os dados da unidade
    $sql = "SELECT nome_escola, id_cidade, habilita, outros, independentes, portatil, lcd FROM unidade_escolar WHERE id_unidade = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_unidade);
    $stmt->execute();
    $stmt->bind_result($nome_escola, $id_cidade, $habilita, $outros, $independentes, $portatil, $lcd);
    $stmt->fetch();
    $stmt->close();
    
    // Verifica se a unidade existe
    if (!$nome_escola) {
        echo "<div class='alert alert-danger'>Unidade não encontrada.</div>";
        exit;
    }
}

// Obter lista de cidades para o dropdown
$cidades = [];
$sql_cidades = "SELECT id_cidade, nome_cidade FROM cidades WHERE ativo = 1 ORDER BY nome_cidade";
$cidades_result = executeQuery($sql_cidades);
$cidades = $cidades_result ? $cidades_result->fetchAll() : [];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Unidade Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        h2 {
            color: #667eea;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
        }
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            box-shadow: none;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }
        .form-check-input {
            border-radius: 0.25em;
            margin-top: 0.3em;
        }
        .form-check-label {
            margin-bottom: 0;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
        .alert {
            margin-top: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Unidade Escolar</h2>
        <form method="POST">
            <input type="hidden" name="id_unidade" value="<?php echo htmlspecialchars($id_unidade); ?>">
            
            <div class="mb-3">
                <label for="nome_escola" class="form-label">Nome da Escola:</label>
                <input type="text" name="nome_escola" class="form-control" id="nome_escola" value="<?php echo htmlspecialchars($nome_escola); ?>" required>
            </div>

            <div class="mb-3">
                <label for="id_cidade" class="form-label">Cidade:</label>
                <select name="id_cidade" class="form-select" id="id_cidade" required>
                    <?php foreach ($cidades as $cidade): ?>
                        <option value="<?php echo $cidade['id_cidade']; ?>" <?php echo ($id_cidade == $cidade['id_cidade']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cidade['nome_cidade']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="habilita" class="form-check-input" id="habilita" <?php echo ($habilita ? 'checked' : ''); ?>>
                <label class="form-check-label" for="habilita">Sala Google</label>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="outros" class="form-check-input" id="outros" <?php echo ($outros ? 'checked' : ''); ?>>
                <label class="form-check-label" for="outros">Lousa Interativa</label>
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
                <label class="form-check-label" for="lcd">Lousa LCD</label>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="unidades.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


