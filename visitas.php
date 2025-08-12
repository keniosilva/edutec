<?php
include 'header.php';
require 'conexao.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_unidade = $_POST['id_unidade'];
    $data_visita = $_POST['data_visita'];
    $descricao = $_POST['descricao'];
    
    // Handle file upload
    $anexo = null;
    if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] == 0) {
        $upload_dir = 'uploads/';
        $anexo = $upload_dir . basename($_FILES['anexo']['name']);
        move_uploaded_file($_FILES['anexo']['tmp_name'], $anexo);
    }

    $sql = "INSERT INTO visitas (id_unidade, data_visita, descricao, anexo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $id_unidade, $data_visita, $descricao, $anexo);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Visita registrada com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao registrar visita: " . $conn->error . "</div>";
    }
}

// Fetch unidades for dropdown
$sql_unidades = "SELECT id_unidade, nome_escola FROM unidade_escolar ORDER BY nome_escola";
$result_unidades = $conn->query($sql_unidades);

// Fetch all visits
$sql_visitas = "SELECT v.*, u.nome_escola FROM visitas v INNER JOIN unidade_escolar u ON v.id_unidade = u.id_unidade ORDER BY v.data_visita DESC";
$result_visitas = $conn->query($sql_visitas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Visitas Técnicas - Sistema Edutec</title>
    <style>
        body {
            background-color: #d3d8de;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #b3d7ff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #e0e4e8;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #e0e4e8;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Visitas Técnicas</h2>
        
        <!-- Form for registering visits -->
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id_unidade">Unidade Escolar</label>
                <select name="id_unidade" id="id_unidade" required>
                    <option value="">Selecione uma unidade</option>
                    <?php while ($row = $result_unidades->fetch_assoc()): ?>
                        <option value="<?php echo $row['id_unidade']; ?>"><?php echo htmlspecialchars($row['nome_escola']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="data_visita">Data da Visita</label>
                <input type="date" name="data_visita" id="data_visita" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" required></textarea>
            </div>
            <div class="form-group">
                <label for="anexo">Anexo (opcional)</label>
                <input type="file" name="anexo" id="anexo">
            </div>
            <button type="submit" class="btn">Registrar Visita</button>
        </form>

        <!-- Display registered visits -->
        <h2>Visitas Registradas</h2>
        <?php if ($result_visitas->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Unidade Escolar</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Anexo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_visitas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nome_escola']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['data_visita'])); ?></td>
                            <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                            <td>
                                <?php if ($row['anexo']): ?>
                                    <a href="<?php echo $row['anexo']; ?>" target="_blank">Ver Anexo</a>
                                <?php else: ?>
                                    Nenhum
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-results">Nenhuma visita registrada.</p>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>