<?php
require_once 'auth_check.php'; // Verificar se usuário está logado
require_once 'header.php';
require_once 'conexao.php';

// Obter informações do usuário logado
$user = getLoggedUser();
$user_city_id = $user['id_cidade'] ?? 1;
$is_admin = isAdmin();

$mensagem = "";

// Obter lista de cidades para filtro (apenas para admin)
$cidades = [];
if ($is_admin) {
    $sql_cidades = "SELECT id_cidade, nome_cidade FROM cidades WHERE ativo = 1 ORDER BY nome_cidade";
    $cidades_result = executeQuery($sql_cidades);
    $cidades = $cidades_result ? $cidades_result->fetchAll() : [];
}

// Lógica para inserir nova formação
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_inicio = $_POST["data_inicio"];
    $data_fim = $_POST["data_fim"];
    $nome_formacao = trim($_POST["nome_formacao"]);
    $descricao = trim($_POST["descricao"]);
    $id_unidade = $_POST["id_unidade"];
    $documento_frequencia = null;
    $fotos = [];

    // Validação básica
    if (empty($nome_formacao) || empty($descricao) || empty($id_unidade) || empty($data_inicio) || empty($data_fim)) {
        $mensagem = "<div class='alert alert-danger mt-3' role='alert'>Erro: Todos os campos são obrigatórios!</div>";
    } elseif (strtotime($data_fim) < strtotime($data_inicio)) {
        $mensagem = "<div class='alert alert-danger mt-3' role='alert'>Erro: A data de fim deve ser posterior à data de início!</div>";
    } else {
        // Criar diretório para uploads se não existir
        $upload_dir = 'uploads/formacoes/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Processar upload do documento de frequência (PDF)
        if (isset($_FILES['documento_frequencia']) && $_FILES['documento_frequencia']['error'] == UPLOAD_ERR_OK) {
            $file_tmp_name = $_FILES['documento_frequencia']['tmp_name'];
            $file_name = $_FILES['documento_frequencia']['name'];
            $file_size = $_FILES['documento_frequencia']['size'];

            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            // Read the first few bytes to check for PDF magic number
            $handle = fopen($file_tmp_name, 'r');
            $bytes = fread($handle, 4); // Read first 4 bytes
            fclose($handle);

            if ($file_extension == 'pdf' && $bytes == '%PDF') {
                $pdf_name = uniqid() . '_' . basename($file_name);
                $pdf_path = $upload_dir . $pdf_name;
                if (move_uploaded_file($file_tmp_name, $pdf_path)) {
                    $documento_frequencia = $pdf_path;
                } else {
                    $mensagem = "<div class='alert alert-danger mt-3' role='alert'>Erro: Falha ao mover o arquivo PDF.</div>";
                }
            } else {
                $mensagem = "<div class='alert alert-danger mt-3' role='alert'>Erro: Apenas arquivos PDF são permitidos para o documento de frequência!</div>";
            }
        }

        // Processar upload de fotos
        if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            foreach ($_FILES['fotos']['name'] as $key => $name) {
                if ($_FILES['fotos']['error'][$key] == UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    if (in_array($ext, $allowed_extensions)) {
                        $foto_name = uniqid() . '_' . $name;
                        $foto_path = $upload_dir . $foto_name;
                        if (move_uploaded_file($_FILES['fotos']['tmp_name'][$key], $foto_path)) {
                            $fotos[] = $foto_path;
                        }
                    } else {
                        $mensagem = "<div class='alert alert-warning mt-3' role='alert'>Aviso: Arquivo de imagem inválido ignorado: " . htmlspecialchars($name) . "</div>";
                    }
                }
            }
        }

        if (empty($mensagem)) {
            $fotos_json = json_encode($fotos);
            try {
                $stmt = $conn->prepare("INSERT INTO formacoes (data_inicio, data_fim, nome_formacao, descricao, id_unidade, documento_frequencia, fotos) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssiss", $data_inicio, $data_fim, $nome_formacao, $descricao, $id_unidade, $documento_frequencia, $fotos_json);

                if ($stmt->execute()) {
                    $mensagem = "<div class='alert alert-success mt-3' role='alert'>Nova formação adicionada com sucesso!</div>";
                    // Registrar log
                    $log_sql = "INSERT INTO log_sistema (tabela_afetada, acao, usuario) VALUES (?, ?, ?)";
                    executeQuery($log_sql, ['formacoes', 'INSERT', $user['nome']]);
                } else {
                    $mensagem = "<div class='alert alert-danger mt-3' role='alert'>Erro ao adicionar formação: " . $stmt->error . "</div>";
                }
                $stmt->close();
            } catch (Exception $e) {
                $mensagem = "<div class='alert alert-danger mt-3' role='alert'>Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
                error_log("Erro ao cadastrar formação: " . $e->getMessage());
            }
        }
    }
}

// Filtros
$filtro_cidade = isset($_GET['cidade']) ? intval($_GET['cidade']) : 0;
$filtro_unidade = isset($_GET['unidade']) ? intval($_GET['unidade']) : 0;
$filtro_periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '';
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql_formacoes = "SELECT f.*, u.nome_escola, c.nome_cidade 
                  FROM formacoes f 
                  INNER JOIN unidade_escolar u ON f.id_unidade = u.id_unidade 
                  INNER JOIN cidades c ON u.id_cidade = c.id_cidade ";
$params = [];
$where_clauses = [];

if (!$is_admin) {
    $where_clauses[] = "u.id_cidade = ?";
    $params[] = $user_city_id;
} else if ($filtro_cidade > 0) { 
    $where_clauses[] = "u.id_cidade = ?";
    $params[] = $filtro_cidade;
}

if ($filtro_unidade > 0) {
    $where_clauses[] = "f.id_unidade = ?";
    $params[] = $filtro_unidade;
}

if (!empty($search_term)) {
    $where_clauses[] = "(f.nome_formacao LIKE ? OR f.descricao LIKE ?)";
    $params[] = "%" . $search_term . "%";
    $params[] = "%" . $search_term . "%";
}

if (!empty($filtro_periodo)) {
    switch ($filtro_periodo) {
        case 'last_7_days':
            $where_clauses[] = "f.data_inicio >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            break;
        case 'last_30_days':
            $where_clauses[] = "f.data_inicio >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
            break;
        case 'this_month':
            $where_clauses[] = "YEAR(f.data_inicio) = YEAR(CURDATE()) AND MONTH(f.data_inicio) = MONTH(CURDATE())";
            break;
        case 'this_year':
            $where_clauses[] = "YEAR(f.data_inicio) = YEAR(CURDATE())";
            break;
    }
}

if (!empty($where_clauses)) {
    $sql_formacoes .= " WHERE " . implode(" AND ", $where_clauses);
}

$sql_formacoes .= " ORDER BY f.data_inicio DESC";

$result_formacoes = executeQuery($sql_formacoes, $params);
$formacoes = $result_formacoes ? $result_formacoes->fetchAll() : [];

// Obter unidades para o filtro (baseado na cidade do usuário ou todas para admin)
$sql_unidades_filtro = "SELECT id_unidade, nome_escola FROM unidade_escolar";
$params_unidades_filtro = [];
if (!$is_admin) {
    $sql_unidades_filtro .= " WHERE id_cidade = ?";
    $params_unidades_filtro[] = $user_city_id;
} elseif ($filtro_cidade > 0) {
    $sql_unidades_filtro .= " WHERE id_cidade = ?";
    $params_unidades_filtro[] = $filtro_cidade;
}
$sql_unidades_filtro .= " ORDER BY nome_escola";
$result_unidades_filtro = executeQuery($sql_unidades_filtro, $params_unidades_filtro);
$unidades_filtro = $result_unidades_filtro ? $result_unidades_filtro->fetchAll() : [];

// Obter todas as unidades para o formulário de cadastro (baseado na cidade do usuário ou todas para admin)
$sql_unidades_cadastro = "SELECT id_unidade, nome_escola FROM unidade_escolar";
$params_unidades_cadastro = [];
if (!$is_admin) {
    $sql_unidades_cadastro .= " WHERE id_cidade = ?";
    $params_unidades_cadastro[] = $user_city_id;
} else if ($filtro_cidade > 0) { 
    $sql_unidades_cadastro .= " WHERE id_cidade = ?";
    $params_unidades_cadastro[] = $filtro_cidade;
}
$sql_unidades_cadastro .= " ORDER BY nome_escola";
$result_unidades_cadastro = executeQuery($sql_unidades_cadastro, $params_unidades_cadastro);
$unidades_cadastro = $result_unidades_cadastro ? $result_unidades_cadastro->fetchAll() : [];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formações - Sistema EDUTEC</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
        }

        .page-header h2 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .page-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border: none;
            padding: 20px;
        }

        .card-body {
            padding: 30px;
        }

        .form-control, .form-select {
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-outline-secondary {
            background: transparent;
            color: #6c757d;
            border: 2px solid #6c757d;
        }

        .btn-outline-secondary:hover {
            background: #6c757d;
            color: white;
        }

        .btn-outline-warning {
            background: transparent;
            color: #ffc107;
            border: 2px solid #ffc107;
        }

        .btn-outline-warning:hover {
            background: #ffc107;
            color: #212529;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.875rem;
        }

        .table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .table thead {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
        }

        .table th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table td {
            border: none;
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .search-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .stats-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1;
            min-width: 200px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #007bff;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .no-results i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .gallery-item {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 5px;
            margin-bottom: 5px;
            border: 1px solid #eee;
        }

        @media (max-width: 768px) {
            .page-header h2 {
                font-size: 2rem;
            }
            
            .stats-cards {
                flex-direction: column;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Cabeçalho da página -->
        <div class="page-header">
            <h2>📚 Gestão de Formações</h2>
            <p><?php echo $is_admin ? 'Visão Administrativa - Todas as Formações' : 'Formações da sua cidade: ' . htmlspecialchars($user['nome_cidade'] ?? 'Não definida'); ?></p>
        </div>

        <!-- Estatísticas -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($formacoes); ?></div>
                <div class="stat-label">Total de Formações</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php 
                    $formacoes_concluidas = count(array_filter($formacoes, function($f) { 
                        return strtotime($f['data_fim']) < time(); 
                    }));
                    echo $formacoes_concluidas;
                    ?>
                </div>
                <div class="stat-label">Formações Concluídas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php 
                    $formacoes_futuras = count(array_filter($formacoes, function($f) { 
                        return strtotime($f['data_inicio']) > time(); 
                    }));
                    echo $formacoes_futuras;
                    ?>
                </div>
                <div class="stat-label">Formações Futuras</div>
            </div>
        </div>

        <!-- Seção de busca e filtros -->
        <div class="search-section">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h5 class="mb-3">🔍 Buscar e Filtrar Formações</h5>
                    <form method="GET" class="d-flex flex-wrap gap-3">
                        <?php if ($is_admin): ?>
                            <select name="cidade" class="form-select" style="flex: 1; min-width: 150px;" onchange="this.form.submit()">
                                <option value="0">Todas as Cidades</option>
                                <?php foreach ($cidades as $cidade): ?>
                                    <option value="<?php echo $cidade['id_cidade']; ?>" 
                                        <?php echo $filtro_cidade == $cidade['id_cidade'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cidade['nome_cidade']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                        <select name="unidade" class="form-select" style="flex: 1; min-width: 150px;">
                            <option value="0">Todas as Unidades</option>
                            <?php foreach ($unidades_filtro as $unidade): ?>
                                <option value="<?php echo $unidade['id_unidade']; ?>" 
                                    <?php echo $filtro_unidade == $unidade['id_unidade'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($unidade['nome_escola']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <select name="periodo" class="form-select" style="flex: 1; min-width: 150px;">
                            <option value="">Todo o Período</option>
                            <option value="last_7_days" <?php echo $filtro_periodo == 'last_7_days' ? 'selected' : ''; ?>>Últimos 7 Dias</option>
                            <option value="last_30_days" <?php echo $filtro_periodo == 'last_30_days' ? 'selected' : ''; ?>>Últimos 30 Dias</option>
                            <option value="this_month" <?php echo $filtro_periodo == 'this_month' ? 'selected' : ''; ?>>Este Mês</option>
                            <option value="this_year" <?php echo $filtro_periodo == 'this_year' ? 'selected' : ''; ?>>Este Ano</option>
                        </select>
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nome ou descrição..." value="<?php echo htmlspecialchars($search_term); ?>" style="flex: 2; min-width: 200px;">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
                        <a href="formacoes.php" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Limpar Filtros</a>
                    </form>
                </div>
            </div>
        </div>

        <?php echo $mensagem; // Exibir mensagens de sucesso/erro ?>

        <!-- Formulário de Cadastro de Nova Formação -->
        <div class="card">
            <div class="card-header">
                <h3 class="h5 mb-0">➕ Adicionar Nova Formação</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome_formacao" class="form-label">Nome da Formação</label>
                            <input type="text" class="form-control" id="nome_formacao" name="nome_formacao" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_unidade" class="form-label">Unidade Escolar</label>
                            <select class="form-select" id="id_unidade" name="id_unidade" required>
                                <option value="">Selecione a Unidade</option>
                                <?php foreach ($unidades_cadastro as $unidade): ?>
                                    <option value="<?php echo $unidade['id_unidade']; ?>"><?php echo htmlspecialchars($unidade['nome_escola']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_inicio" class="form-label">Data de Início</label>
                            <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data_fim" class="form-label">Data de Fim</label>
                            <input type="date" class="form-control" id="data_fim" name="data_fim" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="documento_frequencia" class="form-label">Documento de Frequência (PDF)</label>
                        <input type="file" class="form-control" id="documento_frequencia" name="documento_frequencia" accept=".pdf">
                    </div>
                    <div class="mb-3">
                        <label for="fotos" class="form-label">Fotos (Múltiplas)</label>
                        <input type="file" class="form-control" id="fotos" name="fotos[]" multiple accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar Formação</button>
                </form>
            </div>
        </div>

        <!-- Lista de Formações -->
        <h3 class="h5 mb-3">Formações Cadastradas</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Formação</th>
                        <th>Unidade</th>
                        <th>Cidade</th>
                        <th>Período</th>
                        <th>Documento</th>
                        <th>Fotos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($formacoes)): ?>
                        <?php foreach ($formacoes as $formacao): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($formacao['nome_formacao']); ?></td>
                                <td><?php echo htmlspecialchars($formacao['nome_escola']); ?></td>
                                <td><?php echo htmlspecialchars($formacao['nome_cidade']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($formacao['data_inicio'])) . ' a ' . date('d/m/Y', strtotime($formacao['data_fim'])); ?></td>
                                <td>
                                    <?php if (!empty($formacao['documento_frequencia'])): ?>
                                        <a href="<?php echo htmlspecialchars($formacao['documento_frequencia']); ?>" target="_blank" class="btn btn-sm btn-info">Ver PDF</a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                    $fotos = json_decode($formacao['fotos'], true);
                                    if (!empty($fotos)): 
                                        foreach ($fotos as $foto_path): ?>
                                            <img src="<?php echo htmlspecialchars($foto_path); ?>" alt="Foto da Formação" class="img-thumbnail gallery-item">
                                        <?php endforeach; 
                                    else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="editar_formacao.php?id=<?php echo $formacao['id_formacao']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="excluir_formacao.php?id=<?php echo $formacao['id_formacao']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta formação?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Nenhuma formação encontrada com os filtros aplicados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include 'footer.php'; ?>
</body>
</html>


