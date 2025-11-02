<?php
//session_start();
include 'header.php';
require 'conexao.php';

// Verificar se a conexão está funcionando
if (!$conn) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o id_unidade foi passado na URL
if (!isset($_GET['id_unidade']) || empty($_GET['id_unidade'])) {
    die("Erro: ID da unidade não especificado na URL.");
}
$id_unidade = $_GET['id_unidade'];

// Buscar o nome da unidade para exibição
$sql_unidade = "SELECT nome_escola FROM unidade_escolar WHERE id_unidade = ?";
$stmt_unidade = $conn->prepare($sql_unidade);
$stmt_unidade->bind_param("i", $id_unidade);
$stmt_unidade->execute();
$result_unidade = $stmt_unidade->get_result();
if ($result_unidade->num_rows == 0) {
    die("Erro: Unidade não encontrada.");
}
$unidade = $result_unidade->fetch_assoc();
$nome_unidade = $unidade['nome_escola'];
$stmt_unidade->close();

// Listar equipamentos disponíveis
$equipamentos = $conn->query("SELECT id_equipamento, nome_equipamento FROM equipamentos");
if (!$equipamentos) {
    die("Erro na query de equipamentos: " . $conn->error);
}

// Processar o formulário de cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $id_equipamento = $_POST['equipamento'];
    $quantidade = $_POST['quantidade'];
    $numero_serie = $_POST['numero_serie']; // Alterado de 'serie' para 'numero_serie'
    $patrimonio = $_POST['patrimonio'];

    // Verificar se o número de série ou o patrimônio já existem na base de dados
    $sql_verifica = "SELECT id_registro FROM unidade_equipamentos WHERE numero_serie = ? OR patrimonio = ?"; // Alterado de 'serie' para 'numero_serie'
    $stmt_verifica = $conn->prepare($sql_verifica);
    $stmt_verifica->bind_param("ss", $numero_serie, $patrimonio); // Alterado de 'serie' para 'numero_serie'
    $stmt_verifica->execute();
    $resultado_verifica = $stmt_verifica->get_result();

    if ($resultado_verifica->num_rows > 0) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                Equipamento com este número de série ou patrimônio já está cadastrado!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    } else {
        $sql = "INSERT INTO unidade_equipamentos (id_unidade, id_equipamento, quantidade, numero_serie, patrimonio) 
                VALUES (?, ?, ?, ?, ?)"; // Alterado de 'serie' para 'numero_serie'
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Erro ao preparar a query: " . $conn->error);
        }
        $stmt->bind_param("iiiss", $id_unidade, $id_equipamento, $quantidade, $numero_serie, $patrimonio); // Alterado de 'serie' para 'numero_serie'
        if ($stmt->execute()) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Equipamento cadastrado com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Erro ao salvar: ' . $conn->error . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
        }
        $stmt->close();
    }
    $stmt_verifica->close();
}


// Processar o formulário de edição
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    $id_registro = $_POST['id_registro']; // Adicionado para identificar o registro a ser editado
    $id_equipamento_novo = $_POST['equipamento'];
    $quantidade = $_POST['quantidade'];
    $numero_serie = $_POST['numero_serie']; // Alterado de 'serie' para 'numero_serie'
    $patrimonio = $_POST['patrimonio'];

    // Verificar se o número de série ou o patrimônio já existem para OUTROS registros
    $sql_verifica = "SELECT id_registro FROM unidade_equipamentos WHERE (numero_serie = ? OR patrimonio = ?) AND id_registro != ?"; // Alterado de 'serie' para 'numero_serie'
    $stmt_verifica = $conn->prepare($sql_verifica);
    $stmt_verifica->bind_param("ssi", $numero_serie, $patrimonio, $id_registro); // Alterado de 'serie' para 'numero_serie'
    $stmt_verifica->execute();
    $resultado_verifica = $stmt_verifica->get_result();

    if ($resultado_verifica->num_rows > 0) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">Equipamento com este número de série ou patrimônio já está cadastrado em outro registro!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        $stmt_verifica->close();
    } else {
        $stmt_verifica->close();
        $sql = "UPDATE unidade_equipamentos SET id_equipamento = ?, quantidade = ?, numero_serie = ?, patrimonio = ? WHERE id_registro = ?"; // Alterado de 'serie' para 'numero_serie' e WHERE clause
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissi", $id_equipamento_novo, $quantidade, $numero_serie, $patrimonio, $id_registro); // Alterado de 'serie' para 'numero_serie'
        if ($stmt->execute()) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Equipamento atualizado com sucesso!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Erro ao atualizar: ' . $conn->error . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
        $stmt->close();
    }
}

// Listar registros atuais para a unidade específica
$sql_registros = "SELECT ue.*, e.nome_equipamento 
                  FROM unidade_equipamentos ue 
                  JOIN equipamentos e ON ue.id_equipamento = e.id_equipamento 
                  WHERE ue.id_unidade = ?";
$stmt_registros = $conn->prepare($sql_registros);
$stmt_registros->bind_param("i", $id_unidade);
$stmt_registros->execute();
$registros = $stmt_registros->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Equipamentos - <?php echo $nome_unidade; ?></title>
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
        .card {
            border: 1px solid #e0e4e8;
            border-radius: 8px;
            background-color: #ffffff;
        }
        .card-header {
            border-bottom: 1px solid #e0e4e8;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Gerenciar Equipamentos - <?php echo $nome_unidade; ?></h2>
        </div>
        <div class="card-body">
            <!-- Formulário de Cadastro -->
            <form method="POST" class="mb-4">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="row align-items-end">
                    <div class="col-md-6 mb-3">
                        <label for="equipamento" class="form-label fw-bold">Equipamento</label>
                        <select name="equipamento" class="form-select" required>
                            <option value="">Selecione um equipamento</option>
                            <?php 
                            $equipamentos->data_seek(0);
                            while ($equip = $equipamentos->fetch_assoc()): ?>
                                <option value="<?php echo $equip['id_equipamento']; ?>">
                                    <?php echo $equip['nome_equipamento']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="quantidade" class="form-label fw-bold">Quantidade</label>
                        <input type="number" name="quantidade" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="numero_serie" class="form-label fw-bold">Número de Série</label>
                        <input type="text" name="numero_serie" class="form-control" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="patrimonio" class="form-label fw-bold">Patrimônio</label>
                        <input type="text" name="patrimonio" class="form-control" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Salvar</button>
                    </div>
                </div>
            </form>

            <!-- Lista de Equipamentos -->
            <h3 class="h5 mb-3">Equipamentos Cadastrados</h3>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Equipamento</th>
                            <th>Quantidade</th>
                            <th>Número de Série</th>
                            <th>Patrimônio</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($registros->num_rows > 0): ?>
                            <?php while ($registro = $registros->fetch_assoc()): ?>
                                <tr id="row-<?php echo $registro['id_registro']; ?>">
                                    <td><?php echo $registro['nome_equipamento']; ?></td>
                                    <td><?php echo $registro['quantidade']; ?></td>
                                    <td><?php echo $registro['numero_serie']; ?></td>
                                    <td><?php echo $registro['patrimonio']; ?></td>
                                    <td>
                                        <button class="btn btn-outline-warning btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEdicao-<?php echo $registro['id_registro']; ?>">
                                            <i class="bi bi-pencil"></i> Editar
                                        </button>
                                    </td>
                                </tr>
                                <!-- Modal de Edição para cada equipamento -->
<div class="modal fade" id="modalEdicao-<?php echo $registro['id_registro']; ?>" tabindex="-1" aria-labelledby="modalEdicaoLabel-<?php echo $registro['id_registro']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEdicaoLabel-<?php echo $registro['id_registro']; ?>">Editar Equipamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formEdicao-<?php echo $registro['id_registro']; ?>">
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" name="id_registro" value="<?php echo $registro['id_registro']; ?>">
                    <div class="mb-3">
                        <label for="equipamento-<?php echo $registro['id_registro']; ?>" class="form-label fw-bold">Equipamento</label>
                        <select name="equipamento" id="equipamento-<?php echo $registro['id_registro']; ?>" class="form-select" required>
                            <option value="">Selecione um equipamento</option>
                            <?php 
                            $equipamentos->data_seek(0);
                            while ($equip = $equipamentos->fetch_assoc()): ?>
                                <option value="<?php echo $equip['id_equipamento']; ?>" 
                                        <?php echo $equip['id_equipamento'] == $registro['id_equipamento'] ? 'selected' : ''; ?>>
                                    <?php echo $equip['nome_equipamento']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantidade-<?php echo $registro['id_registro']; ?>" class="form-label fw-bold">Quantidade</label>
                        <input type="number" name="quantidade" id="quantidade-<?php echo $registro['id_registro']; ?>" class="form-control" min="0" value="<?php echo $registro['quantidade']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="numero_serie-<?php echo $registro['id_registro']; ?>" class="form-label fw-bold">Número de Série</label>
                        <input type="text" name="numero_serie" id="numero_serie-<?php echo $registro['id_registro']; ?>" class="form-control" value="<?php echo $registro['numero_serie']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="patrimonio-<?php echo $registro['id_registro']; ?>" class="form-label fw-bold">Patrimônio</label>
                        <input type="text" name="patrimonio" id="patrimonio-<?php echo $registro['id_registro']; ?>" class="form-control" value="<?php echo $registro['patrimonio']; ?>" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
                <button type="submit" form="formEdicao-<?php echo $registro['id_registro']; ?>" class="btn btn-primary"><i class="bi bi-save"></i> Salvar</button>
            </div>
        </div>
    </div>
</div>

                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Nenhum equipamento cadastrado para esta unidade.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$stmt_registros->close();
$conn->close();
include 'footer.php';
?>
</body>
</html>


