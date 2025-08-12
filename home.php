<?php 
include 'header.php'; 
require 'conexao.php'; // Arquivo de conexão com o banco de dados

// Consultar formações para verificar alertas
$sql_formacoes = "SELECT f.*, u.nome_escola 
                  FROM formacoes f 
                  INNER JOIN unidade_escolar u ON f.id_unidade = u.id_unidade 
                  ORDER BY f.id_unidade, f.data_fim DESC";
$result_formacoes = $conn->query($sql_formacoes);

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

// Consultar unidades com Sala Google (habilita = 1)
$sql_google = "SELECT id_unidade, nome_escola FROM Unidade_Escolar WHERE habilita = 1 ORDER BY nome_escola";
$result_google = $conn->query($sql_google);

// Consultar unidades que apenas recebem equipamentos (outros = 1)
$sql_equipamentos = "SELECT id_unidade, nome_escola FROM Unidade_Escolar WHERE outros = 1 ORDER BY nome_escola";
$result_equipamentos = $conn->query($sql_equipamentos);

// Consultar unidades que apenas recebem equipamentos (outros = 2)
$sql_independentes = "SELECT id_unidade, nome_escola FROM Unidade_Escolar WHERE independentes = 1 ORDER BY nome_escola";
$result_independentes = $conn->query($sql_independentes);

// Consultar unidades que apenas recebem equipamentos (outros = 3)
$sql_portatil = "SELECT id_unidade, nome_escola FROM Unidade_Escolar WHERE portatil = 1 ORDER BY nome_escola";
$result_portatil = $conn->query($sql_portatil);

// Consultar unidades que apenas recebem equipamentos (outros = 4)
$sql_lcd = "SELECT id_unidade, nome_escola FROM Unidade_Escolar WHERE lcd = 1 ORDER BY nome_escola";
$result_lcd = $conn->query($sql_lcd);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Edutec</title>
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
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Bem-vindo ao Sistema EDUTEC</h2>
        <p>Gerenciamento de equipamentos</p>

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
        <h2>Unidades com Salas Google</h2>
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
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade com Sala Google encontrada.</p></div>";
            }
            ?>
        </div>

        <!-- Unidades que apenas recebem equipamentos -->
        <h2>Unidades com Lousas Interativa</h2>
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
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade apenas com equipamentos encontrada.</p></div>";
            }
            ?>
        </div>
		
		<!-- Unidades que apenas recebem equipamentos -->
        <h2>Unidades com Kit Lousa Portátil</h2>
        <div class="row mt-4">
            <?php
            if ($result_portatil->num_rows > 0) {
                while ($row = $result_portatil->fetch_assoc()) {
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
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade apenas com equipamentos encontrada.</p></div>";
            }
            ?>
        </div>
		
		<h2>Setores independentes</h2>
        <div class="row mt-4">
            <?php
            if ($result_independentes->num_rows > 0) {
                while ($row = $result_independentes->fetch_assoc()) {
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
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade independente encontrada.</p></div>";
            }
            ?>
        </div>
		<h2>Kit Lousa LCD</h2>
        <div class="row mt-4">
            <?php
            if ($result_lcd->num_rows > 0) {
                while ($row = $result_lcd->fetch_assoc()) {
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
                echo "<div class='col-12'><p class='no-results'>Nenhuma unidade com lousa lcd encontrada.</p></div>";
            }
            ?>
        </div>
    </div>



<?php 
$conn->close();
include 'footer.php'; 
?>
</body>
</html>
