<?php 
require_once 'auth_check.php'; // Verificar se usuário está logado
require_once 'header.php'; 
require_once 'conexao.php';

// Obter informações do usuário logado
$user = getLoggedUser();
$user_city_id = $user['id_cidade'] ?? 1;
$is_admin = isAdmin();

// Se for admin, pode ver todas as cidades, senão apenas sua cidade
$city_filter = $is_admin ? "" : "WHERE u.id_cidade = ?";
$params = $is_admin ? [] : [$user_city_id];

// Consulta ao banco de dados com filtro de cidade
$sql = "SELECT u.id_unidade, u.nome_escola, u.habilita, u.outros, u.independentes, u.portatil, u.lcd, c.nome_cidade 
        FROM unidade_escolar u 
        LEFT JOIN cidades c ON u.id_cidade = c.id_cidade 
        $city_filter 
        ORDER BY c.nome_cidade, u.nome_escola ASC";

$result = executeQuery($sql, $params);
$unidades = $result ? $result->fetchAll() : [];

// Obter lista de cidades para filtro (apenas para admin)
$cidades = [];
if ($is_admin) {
    $sql_cidades = "SELECT id_cidade, nome_cidade FROM cidades WHERE ativo = 1 ORDER BY nome_cidade";
    $cidades_result = executeQuery($sql_cidades);
    $cidades = $cidades_result ? $cidades_result->fetchAll() : [];
}

// Filtro por cidade (apenas para admin)
$selected_city = isset($_GET['cidade']) ? intval($_GET['cidade']) : 0;
if ($is_admin && $selected_city > 0) {
    $sql = "SELECT u.id_unidade, u.nome_escola, u.habilita, u.outros, u.independentes, u.portatil, u.lcd, c.nome_cidade 
            FROM unidade_escolar u 
            LEFT JOIN cidades c ON u.id_cidade = c.id_cidade 
            WHERE u.id_cidade = ? 
            ORDER BY u.nome_escola ASC";
    $result = executeQuery($sql, [$selected_city]);
    $unidades = $result ? $result->fetchAll() : [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unidades Escolares - Sistema EDUTEC</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .filters-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-google {
            border-left: 5px solid #4285f4;
        }

        .card-interativa {
            border-left: 5px solid #34a853;
        }

        .card-portatil {
            border-left: 5px solid #fbbc05;
        }

        .card-lcd {
            border-left: 5px solid #ea4335;
        }

        .card-independente {
            border-left: 5px solid #9c27b0;
        }

        .card-body {
            padding: 25px;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-right: 8px;
            margin-bottom: 5px;
            display: inline-block;
        }

        .badge-google { background-color: #4285f4; color: white; }
        .badge-interativa { background-color: #34a853; color: white; }
        .badge-portatil { background-color: #fbbc05; color: #333; }
        .badge-lcd { background-color: #ea4335; color: white; }
        .badge-independente { background-color: #9c27b0; color: white; }
        .badge-cidade { background-color: #6c757d; color: white; }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.875rem;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .no-results i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
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

        @media (max-width: 768px) {
            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .page-header h2 {
                font-size: 2rem;
            }
        }

        .form-select {
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
            color: #667eea;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Cabeçalho da página -->
        <div class="page-header">
            <h2>🏫 Unidades Escolares</h2>
            <p><?php echo $is_admin ? 'Visão Administrativa - Todas as Cidades' : 'Cidade: ' . htmlspecialchars($user['nome_cidade'] ?? 'Não definida'); ?></p>
        </div>

        <!-- Estatísticas -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($unidades); ?></div>
                <div class="stat-label">Total de Unidades</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo count(array_filter($unidades, function($u) { return $u['habilita']; })); ?></div>
                <div class="stat-label">Salas Google</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo count(array_filter($unidades, function($u) { return $u['outros']; })); ?></div>
                <div class="stat-label">Lousas Interativas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo count(array_filter($unidades, function($u) { return $u['portatil']; })); ?></div>
                <div class="stat-label">Kits Portáteis</div>
            </div>
        </div>

        <!-- Filtros (apenas para admin) -->
        <?php if ($is_admin): ?>
        <div class="filters-section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-3">🔍 Filtros</h5>
                    <form method="GET" class="d-flex gap-3">
                        <select name="cidade" class="form-select" onchange="this.form.submit()">
                            <option value="0">Todas as cidades</option>
                            <?php foreach ($cidades as $cidade): ?>
                                <option value="<?php echo $cidade['id_cidade']; ?>" 
                                    <?php echo $selected_city == $cidade['id_cidade'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cidade['nome_cidade']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <a href="adicionar_unidade.php" class="btn btn-primary">
                        ➕ Adicionar Unidade
                    </a>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="filters-section">
            <div class="text-end">
                <a href="adicionar_unidade.php" class="btn btn-primary">
                    ➕ Adicionar Unidade
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Lista de Unidades -->
        <div class="row">
            <?php if (!empty($unidades)): ?>
                <?php foreach ($unidades as $unidade): ?>
                    <?php
                    // Determinar classe do card baseado no tipo
                    $card_class = 'card';
                    if ($unidade['habilita']) $card_class .= ' card-google';
                    elseif ($unidade['outros']) $card_class .= ' card-interativa';
                    elseif ($unidade['portatil']) $card_class .= ' card-portatil';
                    elseif ($unidade['lcd']) $card_class .= ' card-lcd';
                    elseif ($unidade['independentes']) $card_class .= ' card-independente';
                    ?>
                    <div class="col-md-4">
                        <div class="<?php echo $card_class; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($unidade['nome_escola']); ?></h5>
                                
                                <!-- Badges de tipo -->
                                <div class="mb-3">
                                    <?php if ($unidade['habilita']): ?>
                                        <span class="badge badge-google">🏫 Sala Google</span>
                                    <?php endif; ?>
                                    <?php if ($unidade['outros']): ?>
                                        <span class="badge badge-interativa">📱 Lousa Interativa</span>
                                    <?php endif; ?>
                                    <?php if ($unidade['portatil']): ?>
                                        <span class="badge badge-portatil">💼 Kit Portátil</span>
                                    <?php endif; ?>
                                    <?php if ($unidade['lcd']): ?>
                                        <span class="badge badge-lcd">🖥️ Lousa LCD</span>
                                    <?php endif; ?>
                                    <?php if ($unidade['independentes']): ?>
                                        <span class="badge badge-independente">🏢 Independentes</span>
                                    <?php endif; ?>
                                    <?php if ($is_admin): ?>
                                        <span class="badge badge-cidade">📍 <?php echo htmlspecialchars($unidade['nome_cidade'] ?? 'Sem cidade'); ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Ações -->
                                <div class="d-flex gap-2">
                                    <a href="gerenciar_unidade_equipamento.php?id_unidade=<?php echo $unidade['id_unidade']; ?>" 
                                       class="btn btn-primary btn-sm">
                                        👁️ Visualizar
                                    </a>
                                    <a href="editar_unidade.php?id=<?php echo $unidade['id_unidade']; ?>" 
                                       class="btn btn-warning btn-sm">
                                        ✏️ Editar
                                    </a>
                                    <a href="excluir_unidade.php?id=<?php echo $unidade['id_unidade']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Tem certeza que deseja excluir esta unidade?')">
                                        🗑️ Excluir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="no-results">
                        <i>🏫</i>
                        <h3>Nenhuma unidade encontrada</h3>
                        <p>Não há unidades escolares cadastradas <?php echo $is_admin && $selected_city > 0 ? 'para a cidade selecionada' : 'para sua cidade'; ?>.</p>
                        <a href="adicionar_unidade.php" class="btn btn-primary">
                            ➕ Adicionar Primeira Unidade
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Auto-refresh da página a cada 5 minutos para manter dados atualizados
        setTimeout(function() {
            location.reload();
        }, 300000);
    </script>

<?php include 'footer.php'; ?>
</body>
</html>


