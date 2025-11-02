<?php 
require_once 'auth_check.php'; // Verificar se usuário está logado
require_once 'header.php'; 
require_once 'conexao.php';

// Verificar se o usuário tem acesso a João Pessoa (id_cidade = 2)
if (!checkCityAccess(2)) {
    header("Location: home.php");
    exit;
}

// Obter informações do usuário logado
$user = getLoggedUser();
$user_city_id = 2; // João Pessoa

// Consultar formações para verificar alertas (filtrado por João Pessoa)
$sql_formacoes = "SELECT f.*, u.nome_escola 
                  FROM formacoes f 
                  INNER JOIN unidade_escolar u ON f.id_unidade = u.id_unidade 
                  WHERE u.id_cidade = ?
                  ORDER BY f.id_unidade, f.data_fim DESC";
$formacoes_result = executeQuery($sql_formacoes, [$user_city_id]);
$formacoes = $formacoes_result ? $formacoes_result->fetchAll() : [];

$alertas_formacao = [];
$unidades_processadas = [];

foreach ($formacoes as $row) {
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

// Consultar unidades com Sala Google (habilita = 1) filtrado por João Pessoa
$sql_google = "SELECT id_unidade, nome_escola FROM unidade_escolar WHERE habilita = 1 AND id_cidade = ? ORDER BY nome_escola";
$google_result = executeQuery($sql_google, [$user_city_id]);
$unidades_google = $google_result ? $google_result->fetchAll() : [];

// Consultar unidades que apenas recebem equipamentos (outros = 1) filtrado por João Pessoa
$sql_equipamentos = "SELECT id_unidade, nome_escola FROM unidade_escolar WHERE outros = 1 AND id_cidade = ? ORDER BY nome_escola";
$equipamentos_result = executeQuery($sql_equipamentos, [$user_city_id]);
$unidades_equipamentos = $equipamentos_result ? $equipamentos_result->fetchAll() : [];

// Consultar unidades independentes (independentes = 1) filtrado por João Pessoa
$sql_independentes = "SELECT id_unidade, nome_escola FROM unidade_escolar WHERE independentes = 1 AND id_cidade = ? ORDER BY nome_escola";
$independentes_result = executeQuery($sql_independentes, [$user_city_id]);
$unidades_independentes = $independentes_result ? $independentes_result->fetchAll() : [];

// Consultar unidades com lousa portátil (portatil = 1) filtrado por João Pessoa
$sql_portatil = "SELECT id_unidade, nome_escola FROM unidade_escolar WHERE portatil = 1 AND id_cidade = ? ORDER BY nome_escola";
$portatil_result = executeQuery($sql_portatil, [$user_city_id]);
$unidades_portatil = $portatil_result ? $portatil_result->fetchAll() : [];

// Consultar unidades com LCD (lcd = 1) filtrado por João Pessoa
$sql_lcd = "SELECT id_unidade, nome_escola FROM unidade_escolar WHERE lcd = 1 AND id_cidade = ? ORDER BY nome_escola";
$lcd_result = executeQuery($sql_lcd, [$user_city_id]);
$unidades_lcd = $lcd_result ? $lcd_result->fetchAll() : [];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Edutec - João Pessoa</title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            border: 1px solid #e0e4e8;
            border-radius: 12px;
            transition: all 0.3s ease;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            border-color: #667eea;
        }

        .bg-joao-pessoa-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-left: 4px solid #5a6fd8;
        }

        .bg-joao-pessoa-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-left: 4px solid #e91e63;
        }

        .bg-joao-pessoa-tertiary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-left: 4px solid #2196f3;
        }

        .bg-joao-pessoa-quaternary {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            border-left: 4px solid #4caf50;
        }

        .card-body {
            padding: 25px;
        }

        .card-title {
            margin-bottom: 0;
            font-size: 1.3rem;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        h2 {
            color: white;
            border-bottom: 3px solid rgba(255,255,255,0.3);
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .no-results {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            color: #666;
            backdrop-filter: blur(10px);
        }

        .alert-formacao {
            background: rgba(255, 243, 205, 0.95);
            border: 1px solid #ffeaa7;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid #f39c12;
            backdrop-filter: blur(10px);
        }

        .alert-formacao h5 {
            color: #856404;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .alert-formacao p {
            color: #856404;
            margin-bottom: 8px;
        }

        .alert-formacao .btn {
            margin-top: 15px;
        }

        .city-header {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 40px;
            text-align: center;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .city-header h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
        }

        .city-header p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .user-info {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
            color: #212529;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #e0a800 0%, #e65100 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-outline-light {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.5);
        }

        .btn-outline-light:hover {
            background: rgba(255,255,255,0.2);
            border-color: white;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.875rem;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -15px;
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 15px;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 15px;
        }

        .mb-4 {
            margin-bottom: 2rem;
        }

        .h-100 {
            height: 100%;
        }

        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }

        .text-decoration-none {
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .city-header h1 {
                font-size: 2rem;
            }
            
            .user-info {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }

        /* Animações especiais para João Pessoa */
        @keyframes joaoPessoaGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.3); }
            50% { box-shadow: 0 0 30px rgba(102, 126, 234, 0.6); }
        }

        .card:hover {
            animation: joaoPessoaGlow 2s infinite;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Cabeçalho da cidade -->
        <div class="city-header">
            <h1>🏖️ EDUTEC João Pessoa</h1>
            <p>Capital da Paraíba - Gestão Educacional Avançada</p>
        </div>

        <!-- Informações do usuário -->
        <div class="user-info">
            <div>
                <strong>👤 Usuário:</strong> <?php echo htmlspecialchars($user['nome']); ?> | 
                <strong>🏙️ Cidade:</strong> João Pessoa
            </div>
            <div>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
            </div>
        </div>

        <!-- Alertas de Formação -->
        <?php if (!empty($alertas_formacao)): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <h3>⚠️ Alertas de Formação - João Pessoa</h3>
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
        <h2>🏫 Unidades com Salas Google - João Pessoa</h2>
        <div class="row mt-4">
            <?php
            if (!empty($unidades_google)) {
                foreach ($unidades_google as $row) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card h-100 shadow-lg bg-joao-pessoa-primary'>";
                    echo "<a href='gerenciar_unidade_equipamento.php?id_unidade={$row['id_unidade']}' class='text-decoration-none'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['nome_escola']}</h5>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade com Sala Google encontrada em João Pessoa.</p></div>";
            }
            ?>
        </div>

        <!-- Unidades com Lousas Interativas -->
        <h2>📱 Unidades com Lousas Interativas - João Pessoa</h2>
        <div class="row mt-4">
            <?php
            if (!empty($unidades_equipamentos)) {
                foreach ($unidades_equipamentos as $row) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card h-100 shadow-lg bg-joao-pessoa-secondary'>";
                    echo "<a href='gerenciar_unidade_equipamento.php?id_unidade={$row['id_unidade']}' class='text-decoration-none'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['nome_escola']}</h5>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade com lousas interativas encontrada em João Pessoa.</p></div>";
            }
            ?>
        </div>
        
        <!-- Unidades com Kit Lousa Portátil -->
        <h2>💼 Unidades com Kit Lousa Portátil - João Pessoa</h2>
        <div class="row mt-4">
            <?php
            if (!empty($unidades_portatil)) {
                foreach ($unidades_portatil as $row) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card h-100 shadow-lg bg-joao-pessoa-tertiary'>";
                    echo "<a href='gerenciar_unidade_equipamento.php?id_unidade={$row['id_unidade']}' class='text-decoration-none'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['nome_escola']}</h5>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade com kit lousa portátil encontrada em João Pessoa.</p></div>";
            }
            ?>
        </div>
        
        <!-- Kit Lousa LCD -->
        <h2>🖥️ Kit Lousa LCD - João Pessoa</h2>
        <div class="row mt-4">
            <?php
            if (!empty($unidades_lcd)) {
                foreach ($unidades_lcd as $row) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card h-100 shadow-lg bg-joao-pessoa-quaternary'>";
                    echo "<a href='gerenciar_unidade_equipamento.php?id_unidade={$row['id_unidade']}' class='text-decoration-none'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['nome_escola']}</h5>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade com lousa LCD encontrada em João Pessoa.</p></div>";
            }
            ?>
        </div>
    </div>

<?php 
include 'footer.php'; 
?>
</body>
</html>

