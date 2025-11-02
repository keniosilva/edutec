<?php 
session_start();
require_once 'conexao.php';

// Verificar se usuário está logado e é admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

// Obter informações do usuário logado
$user_name = $_SESSION['user'] ?? 'Administrador';
$user_login = $_SESSION['user_login'] ?? 'admin';

// Consultar todas as cidades disponíveis
try {
    $cidades_sql = "SELECT id_cidade, nome_cidade FROM cidades WHERE ativo = 1 ORDER BY nome_cidade";
    $cidades_result = executeQuery($cidades_sql);
    $cidades = $cidades_result ? $cidades_result->fetchAll() : [];
} catch (Exception $e) {
    error_log("Erro ao carregar cidades: " . $e->getMessage());
    $cidades = [];
}

// Consultar estatísticas gerais do sistema
$stats = [];

try {
    // Total de unidades escolares por cidade
    $sql_unidades = "SELECT c.nome_cidade, COUNT(u.id_unidade) as total 
                     FROM cidades c 
                     LEFT JOIN unidade_escolar u ON c.id_cidade = u.id_cidade 
                     WHERE c.ativo = 1 
                     GROUP BY c.id_cidade, c.nome_cidade 
                     ORDER BY c.nome_cidade";
    $result_unidades = executeQuery($sql_unidades);
    $stats['unidades_por_cidade'] = $result_unidades ? $result_unidades->fetchAll() : [];

    // Total geral de equipamentos
    $sql_equipamentos_total = "SELECT COUNT(*) as total FROM unidade_equipamentos";
    $result_equipamentos_total = executeQuery($sql_equipamentos_total);
    $stats['equipamentos_total'] = $result_equipamentos_total ? $result_equipamentos_total->fetch()['total'] : 0;

    // Total geral de formações
    $sql_formacoes_total = "SELECT COUNT(*) as total FROM formacoes";
    $result_formacoes_total = executeQuery($sql_formacoes_total);
    $stats['formacoes_total'] = $result_formacoes_total ? $result_formacoes_total->fetch()['total'] : 0;

    // Total geral de usuários
    $sql_usuarios_total = "SELECT COUNT(*) as total FROM usuario WHERE status = 'ativo'";
    $result_usuarios_total = executeQuery($sql_usuarios_total);
    $stats['usuarios_total'] = $result_usuarios_total ? $result_usuarios_total->fetch()['total'] : 0;

} catch (Exception $e) {
    error_log("Erro ao carregar estatísticas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo - EDUTEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .admin-header {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 40px;
            text-align: center;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .admin-header h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
        }

        .admin-header p {
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .stat-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1rem;
            color: #6c757d;
            font-weight: 600;
        }

        .cities-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .cities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .city-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
        }

        .city-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .city-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
            text-decoration: none;
            color: white;
        }

        .city-card:hover::before {
            opacity: 1;
        }

        .city-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .city-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .city-stat {
            text-align: center;
        }

        .city-stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            display: block;
        }

        .city-stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
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

        .btn-outline-light {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.5);
        }

        .btn-outline-light:hover {
            background: rgba(255,255,255,0.2);
            border-color: white;
            transform: translateY(-2px);
            color: white;
        }

        .section-title {
            color: #333;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .no-cities {
            text-align: center;
            color: #6c757d;
            font-size: 1.2rem;
            padding: 40px;
        }

        @media (max-width: 768px) {
            .admin-header h1 {
                font-size: 2rem;
            }
            
            .user-info {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .cities-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }

        /* Animações especiais */
        @keyframes adminGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.3); }
            50% { box-shadow: 0 0 30px rgba(102, 126, 234, 0.6); }
        }

        .city-card:hover {
            animation: adminGlow 2s infinite;
        }

        .crown-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            opacity: 0.7;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Cabeçalho administrativo -->
        <div class="admin-header">
            <h1>👑 Dashboard Administrativo EDUTEC</h1>
            <p>Painel de Controle Multi-Cidades</p>
        </div>

        <!-- Informações do usuário -->
        <div class="user-info">
            <div>
                <strong>👤 Administrador:</strong> <?php echo htmlspecialchars($user_name); ?> 
                <span class="badge bg-warning text-dark ms-2">ADMIN</span>
            </div>
            <div>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
            </div>
        </div>

        <!-- Estatísticas gerais -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🏫</div>
                <div class="stat-number"><?php echo array_sum(array_column($stats['unidades_por_cidade'], 'total')); ?></div>
                <div class="stat-label">Total de Unidades</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💻</div>
                <div class="stat-number"><?php echo $stats['equipamentos_total']; ?></div>
                <div class="stat-label">Total de Equipamentos</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-number"><?php echo $stats['formacoes_total']; ?></div>
                <div class="stat-label">Total de Formações</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-number"><?php echo $stats['usuarios_total']; ?></div>
                <div class="stat-label">Usuários Ativos</div>
            </div>
        </div>

        <!-- Seção de cidades -->
        <div class="cities-section">
            <h2 class="section-title">🏙️ Selecione uma Cidade para Gerenciar</h2>
            
            <?php if (!empty($cidades)): ?>
                <div class="cities-grid">
                    <?php foreach ($cidades as $cidade): ?>
                        <?php
                        // Buscar estatísticas específicas da cidade
                        $unidades_cidade = 0;
                        foreach ($stats['unidades_por_cidade'] as $stat) {
                            if ($stat['nome_cidade'] === $cidade['nome_cidade']) {
                                $unidades_cidade = $stat['total'];
                                break;
                            }
                        }
                        
                        // Definir ícone e cor baseado na cidade
                        $city_icons = [
                            'Bayeux' => '🌊',
                            'João Pessoa' => '🏖️',
                            'Cabedelo' => '⛵',
                            'Pitimbu' => '🌴',
                            'Conceição' => '🏛️'
                        ];
                        $icon = $city_icons[$cidade['nome_cidade']] ?? '🏙️';
                        ?>
                        
                        <a href="home.php?cidade=<?php echo $cidade['id_cidade']; ?>" class="city-card">
                            <div class="crown-icon">👑</div>
                            <div class="city-name">
                                <?php echo $icon; ?> <?php echo htmlspecialchars($cidade['nome_cidade']); ?>
                            </div>
                            <div class="city-stats">
                                <div class="city-stat">
                                    <span class="city-stat-number"><?php echo $unidades_cidade; ?></span>
                                    <span class="city-stat-label">Unidades</span>
                                </div>
                                <div class="city-stat">
                                    <span class="city-stat-number">→</span>
                                    <span class="city-stat-label">Acessar</span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-cities">
                    <p>Nenhuma cidade encontrada no sistema.</p>
                    <p>Verifique a configuração do banco de dados.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Informações adicionais -->
        <div class="cities-section">
            <h3 class="section-title">ℹ️ Informações do Sistema</h3>
            <div class="row">
                <div class="col-md-6">
                    <h5>📊 Distribuição por Cidade</h5>
                    <?php if (!empty($stats['unidades_por_cidade'])): ?>
                        <ul class="list-group">
                            <?php foreach ($stats['unidades_por_cidade'] as $stat): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($stat['nome_cidade']); ?>
                                    <span class="badge bg-primary rounded-pill"><?php echo $stat['total']; ?> unidades</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h5>🔧 Funcionalidades Administrativas</h5>
                    <ul class="list-group">
                        <li class="list-group-item">✅ Acesso a todas as cidades</li>
                        <li class="list-group-item">✅ Visualização de estatísticas gerais</li>
                        <li class="list-group-item">✅ Gerenciamento multi-cidade</li>
                        <li class="list-group-item">✅ Relatórios consolidados</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Adicionar efeitos visuais
        document.addEventListener('DOMContentLoaded', function() {
            // Animação de entrada para os cards
            const cards = document.querySelectorAll('.city-card, .stat-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>

