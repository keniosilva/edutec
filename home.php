<?php 
require_once 'auth_check.php'; // Verificar se usuário está logado
require_once 'header.php'; 
require_once 'conexao.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Obter informações do usuário logado
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user'] ?? 'Usuário';
$user_city_id = $_SESSION['user_id_cidade'] ?? null;
$user_city_name = $_SESSION['user_nome_cidade'] ?? 'Cidade não identificada';

// Se não há cidade definida, usar Bayeux como padrão (ID = 1)
if (!$user_city_id) {
    $user_city_id = 1;
    $user_city_name = 'Bayeux';
}

// Consultar formações para verificar alertas (filtrado por cidade)
$sql_formacoes = "SELECT f.*, u.nome_escola 
                  FROM formacoes f 
                  INNER JOIN unidade_escolar u ON f.id_unidade = u.id_unidade 
                  WHERE u.id_cidade = ?
                  ORDER BY f.id_unidade, f.data_fim DESC";
$stmt_formacoes = $conn->prepare($sql_formacoes);
$stmt_formacoes->bind_param("i", $user_city_id);
$stmt_formacoes->execute();
$result_formacoes = $stmt_formacoes->get_result();

$formacoes = [];
$alertas_formacao = [];
$unidades_processadas = [];

if ($result_formacoes->num_rows > 0) {
    while($row = $result_formacoes->fetch_assoc()) {
        $formacoes[] = $row;
        
        // Processar apenas a formação mais recente de cada unidade
        if (!in_array($row['id_unidade'], $unidades_processadas)) {
            $unidades_processadas[] = $row['id_unidade'];
            
            // Verificar se precisa de alerta
            $data_fim = new DateTime($row['data_fim']);
            $hoje = new DateTime();
            $seis_meses_antes = clone $data_fim;
            $seis_meses_antes->modify('-6 months');
            $seis_meses_depois = clone $data_fim;
            $seis_meses_depois->modify('+6 months');
            
            // Alerta para formações próximas do fim (menos de 6 meses)
            if ($hoje >= $seis_meses_antes && $hoje <= $data_fim) {
                $alertas_formacao[] = [
                    'tipo' => 'proximo_fim',
                    'formacao' => $row['nome_formacao'],
                    'unidade' => $row['nome_escola'],
                    'data_fim' => $row['data_fim'],
                    'id_unidade' => $row['id_unidade']
                ];
            }
            // Alerta para formações concluídas há mais de 6 meses
            elseif ($hoje > $data_fim && $hoje > $seis_meses_depois) {
                $alertas_formacao[] = [
                    'tipo' => 'vencida',
                    'formacao' => $row['nome_formacao'],
                    'unidade' => $row['nome_escola'],
                    'data_fim' => $row['data_fim'],
                    'id_unidade' => $row['id_unidade']
                ];
            }
        }
    }
}

// Consultar unidades com Sala Google (habilita = 1) filtrado por cidade
$sql_google = "SELECT id_unidade, nome_escola FROM unidade_escolar WHERE habilita = 1 AND id_cidade = ? ORDER BY nome_escola";
$stmt_google = $conn->prepare($sql_google);
$stmt_google->bind_param("i", $user_city_id);
$stmt_google->execute();
$result_google = $stmt_google->get_result();

// Consultar unidades que apenas recebem equipamentos (outros = 1) filtrado por cidade
$sql_equipamentos = "SELECT id_unidade, nome_escola FROM unidade_escolar WHERE outros = 1 AND id_cidade = ? ORDER BY nome_escola";
$stmt_equipamentos = $conn->prepare($sql_equipamentos);
$stmt_equipamentos->bind_param("i", $user_city_id);
$stmt_equipamentos->execute();
$result_equipamentos = $stmt_equipamentos->get_result();

// Consultar unidades independentes (independentes = 1) filtrado por cidade
$sql_independentes = "SELECT id_unidade, nome_escola FROM unidade_escolar WHERE independentes = 1 AND id_cidade = ? ORDER BY nome_escola";
$stmt_independentes = $conn->prepare($sql_independentes);
$stmt_independentes->bind_param("i", $user_city_id);
$stmt_independentes->execute();
$result_independentes = $stmt_independentes->get_result();

// Consultar unidades com lousa portátil (portatil = 1) filtrado por cidade
$sql_portatil = "SELECT id_unidade, nome_escola FROM unidade_escolar WHERE portatil = 1 AND id_cidade = ? ORDER BY nome_escola";
$stmt_portatil = $conn->prepare($sql_portatil);
$stmt_portatil->bind_param("i", $user_city_id);
$stmt_portatil->execute();
$result_portatil = $stmt_portatil->get_result();

// Consultar unidades com LCD (lcd = 1) filtrado por cidade
$sql_lcd = "SELECT id_unidade, nome_escola FROM unidade_escolar WHERE lcd = 1 AND id_cidade = ? ORDER BY nome_escola";
$stmt_lcd = $conn->prepare($sql_lcd);
$stmt_lcd->bind_param("i", $user_city_id);
$stmt_lcd->execute();
$result_lcd = $stmt_lcd->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Edutec - <?php echo htmlspecialchars($user_city_name); ?></title>
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
            transition: all 0.3s ease;
            overflow: hidden;
            background-color: #ffffff;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            border-color: #b3d7ff;
        }

        .bg-light-green {
            background-color: #e8f5e9;
            color: #2d6a4f;
            border-left: 3px solid #a5d6a7;
        }

        .bg-light-blue {
            background-color: #e9f1fb;
            color: #1e4976;
            border-left: 3px solid #b3d7ff;
        }

        .bg-light-purple {
            background-color: #f3e5f5;
            color: #6a1b9a;
            border-left: 3px solid #ce93d8;
        }

        .bg-light-orange {
            background-color: #fff3e0;
            color: #e65100;
            border-left: 3px solid #ffb74d;
        }

        .bg-light-red {
            background-color: #ffebee;
            color: #c62828;
            border-left: 3px solid #ef5350;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            margin-bottom: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #b3d7ff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .no-results {
            background-color: #ffffff;
            border: 1px solid #e0e4e8;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            color: #666;
        }

        .alert-formacao {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #f39c12;
        }

        .alert-formacao h5 {
            color: #856404;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .alert-formacao p {
            color: #856404;
            margin-bottom: 5px;
        }

        .alert-formacao .btn {
            margin-top: 10px;
        }

        .city-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
        }

        .user-info {
            background: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            border: 1px solid #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-outline-secondary {
            background-color: transparent;
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 0.875rem;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -10px;
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 10px;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 10px;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .h-100 {
            height: 100%;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .text-decoration-none {
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .user-info {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Cabeçalho da cidade -->
        <div class="city-header">
            <h1>Sistema EDUTEC - <?php echo htmlspecialchars($user_city_name); ?></h1>
            <p>Gerenciamento de equipamentos educacionais</p>
        </div>

        <!-- Informações do usuário -->
        <div class="user-info">
            <div>
                <strong>📊 Resumo Geral:</strong> <?php echo htmlspecialchars($user_city_name); ?> | 
                <strong>📅 Data:</strong> <?php echo date('d/m/Y'); ?>
            </div>
            <div>
                <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">📈 Dashboard Completo</a>
            </div>
        </div>

        <!-- Estatísticas rápidas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $result_google->num_rows; ?></div>
                <div class="stat-label">Salas Google</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $result_equipamentos->num_rows; ?></div>
                <div class="stat-label">Lousas Interativas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $result_portatil->num_rows; ?></div>
                <div class="stat-label">Kits Portáteis</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $result_lcd->num_rows; ?></div>
                <div class="stat-label">Kits LCD</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $result_independentes->num_rows; ?></div>
                <div class="stat-label">Setores Independentes</div>
            </div>
        </div>

        <!-- Alertas de Formação -->
        <?php if (!empty($alertas_formacao)): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <h3>⚠️ Alertas de Formação</h3>
                    <?php foreach ($alertas_formacao as $alerta): ?>
                        <div class="alert-formacao">
                            <?php if ($alerta['tipo'] == 'proximo_fim'): ?>
                                <h5>🕒 Formação Próxima do Fim</h5>
                                <p><strong>Formação:</strong> <?php echo htmlspecialchars($alerta['formacao']); ?></p>
                                <p><strong>Unidade:</strong> <?php echo htmlspecialchars($alerta['unidade']); ?></p>
                                <p><strong>Data de Conclusão:</strong> <?php echo date('d/m/Y', strtotime($alerta['data_fim'])); ?></p>
                                <p>Esta formação está a menos de 6 meses da conclusão. Uma nova formação deve ser agendada.</p>
                            <?php else: ?>
                                <h5>⏰ Formação Vencida</h5>
                                <p><strong>Formação:</strong> <?php echo htmlspecialchars($alerta['formacao']); ?></p>
                                <p><strong>Unidade:</strong> <?php echo htmlspecialchars($alerta['unidade']); ?></p>
                                <p><strong>Data de Conclusão:</strong> <?php echo date('d/m/Y', strtotime($alerta['data_fim'])); ?></p>
                                <p>Esta formação foi concluída há mais de 6 meses. Verifique a necessidade de uma nova formação.</p>
                            <?php endif; ?>
                            <a href="formacoes.php" class="btn btn-warning btn-sm">Agendar Nova Formação</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Unidades com Sala Google -->
        <h2>🏫 Unidades com Salas Google</h2>
        <div class="row mt-4">
            <?php
            if ($result_google->num_rows > 0) {
                while ($row = $result_google->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card h-100 shadow-sm bg-light-blue'>";
                    echo "<a href='gerenciar_unidade_equipamento.php?id_unidade={$row['id_unidade']}' class='text-decoration-none'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['nome_escola']}</h5>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade com Sala Google encontrada em " . htmlspecialchars($user_city_name) . ".</p></div>";
            }
            ?>
        </div>

        <!-- Unidades com Lousas Interativas -->
        <h2>📱 Unidades com Lousas Interativas</h2>
        <div class="row mt-4">
            <?php
            if ($result_equipamentos->num_rows > 0) {
                while ($row = $result_equipamentos->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card h-100 shadow-sm bg-light-green'>";
                    echo "<a href='gerenciar_unidade_equipamento.php?id_unidade={$row['id_unidade']}' class='text-decoration-none'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['nome_escola']}</h5>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade com lousas interativas encontrada em " . htmlspecialchars($user_city_name) . ".</p></div>";
            }
            ?>
        </div>
        
        <!-- Unidades com Kit Lousa Portátil -->
        <h2>💼 Unidades com Kit Lousa Portátil</h2>
        <div class="row mt-4">
            <?php
            if ($result_portatil->num_rows > 0) {
                while ($row = $result_portatil->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card h-100 shadow-sm bg-light-purple'>";
                    echo "<a href='gerenciar_unidade_equipamento.php?id_unidade={$row['id_unidade']}' class='text-decoration-none'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['nome_escola']}</h5>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade com kit lousa portátil encontrada em " . htmlspecialchars($user_city_name) . ".</p></div>";
            }
            ?>
        </div>
        
        <!-- Setores independentes -->
        <h2>🏢 Setores Independentes</h2>
        <div class="row mt-4">
            <?php
            if ($result_independentes->num_rows > 0) {
                while ($row = $result_independentes->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card h-100 shadow-sm bg-light-orange'>";
                    echo "<a href='gerenciar_unidade_equipamento.php?id_unidade={$row['id_unidade']}' class='text-decoration-none'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['nome_escola']}</h5>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'><p class='no-results'>Nenhum setor independente encontrado em " . htmlspecialchars($user_city_name) . ".</p></div>";
            }
            ?>
        </div>
        
        <!-- Kit Lousa LCD -->
        <h2>🖥️ Kit Lousa LCD</h2>
        <div class="row mt-4">
            <?php
            if ($result_lcd->num_rows > 0) {
                while ($row = $result_lcd->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card h-100 shadow-sm bg-light-red'>";
                    echo "<a href='gerenciar_unidade_equipamento.php?id_unidade={$row['id_unidade']}' class='text-decoration-none'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['nome_escola']}</h5>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade com lousa LCD encontrada em " . htmlspecialchars($user_city_name) . ".</p></div>";
            }
            ?>
        </div>
    </div>

<?php 
// Fechar statements
$stmt_formacoes->close();
$stmt_google->close();
$stmt_equipamentos->close();
$stmt_independentes->close();
$stmt_portatil->close();
$stmt_lcd->close();
$conn->close();
?>
</body>
</html>

