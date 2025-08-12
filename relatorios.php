<?php
// Include dompdf autoloader
if (!file_exists('dompdf/autoload.inc.php')) {
    die('Erro: Arquivo dompdf/autoload.inc.php não encontrado. Verifique se o dompdf está corretamente instalado na pasta dompdf/ no diretório raiz do projeto.');
}
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include 'conexao.php';

// Consulta para formações realizadas
$sql_formacoes = "SELECT f.*, u.nome_escola 
                  FROM formacoes f 
                  INNER JOIN unidade_escolar u ON f.id_unidade = u.id_unidade 
                  ORDER BY f.created_at DESC";
$result_formacoes = $conn->query($sql_formacoes);
$total_formacoes = $result_formacoes->num_rows;
$formacoes = [];
if ($total_formacoes > 0) {
    while ($row = $result_formacoes->fetch_assoc()) {
        $formacoes[] = $row;
    }
}

// Consulta para unidades com equipamentos (apenas unidades com pelo menos um equipamento)
$sql_equipamentos = "SELECT u.nome_escola, COUNT(ue.id_registro) as total_equipamentos, SUM(ue.quantidade) as quantidade_total
                     FROM unidade_escolar u
                     INNER JOIN unidade_equipamentos ue ON u.id_unidade = ue.id_unidade
                     INNER JOIN equipamentos e ON ue.id_equipamento = e.id_equipamento
                     GROUP BY u.id_unidade, u.nome_escola
                     HAVING total_equipamentos > 0
                     ORDER BY u.nome_escola";
$result_equipamentos = $conn->query($sql_equipamentos);
$unidades_equipamentos = [];
if ($result_equipamentos->num_rows > 0) {
    while ($row = $result_equipamentos->fetch_assoc()) {
        $unidades_equipamentos[] = $row;
    }
}

// Gerar PDF se solicitado
if (isset($_GET['export']) && $_GET['export'] === 'pdf') {
    $dompdf = new Dompdf();

    // HTML para o PDF
    $html = '
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
            h1 { color: #004085; text-align: center; }
            h2 { color: #004085; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #343a40; color: white; }
            .text-center { text-align: center; }
            .text-danger { color: #dc3545; }
        </style>
    </head>
    <body>
        <h1>Relatório - Sistema Edutec</h1>
        
        <h2>Formações Realizadas</h2>
        <p><strong>Total de Formações:</strong> ' . $total_formacoes . '</p>';
    
    if ($total_formacoes > 0) {
        $html .= '
        <table>
            <thead>
                <tr>
                    <th>Nome da Formação</th>
                    <th>Data Início</th>
                    <th>Data Fim</th>
                    <th>Unidade Escolar</th>
                    <th>Descrição</th>
                    <th>Documento</th>
                    <th>Fotos</th>
                    <th>Cadastrado em</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($formacoes as $formacao) {
            $descricao = htmlspecialchars($formacao['descricao']);
            $descricao = strlen($descricao) > 100 ? substr($descricao, 0, 100) . '...' : $descricao;
            $documento = !empty($formacao['documento_frequencia']) ? 'Disponível' : '-';
            $fotos = !empty(json_decode($formacao['fotos'] ?? '[]', true)) ? 'Disponível' : '-';
            $html .= '
                <tr>
                    <td><strong>' . htmlspecialchars($formacao['nome_formacao']) . '</strong></td>
                    <td>' . date('d/m/Y', strtotime($formacao['data_inicio'])) . '</td>
                    <td>' . date('d/m/Y', strtotime($formacao['data_fim'])) . '</td>
                    <td>' . htmlspecialchars($formacao['nome_escola']) . '</td>
                    <td>' . $descricao . '</td>
                    <td>' . $documento . '</td>
                    <td>' . $fotos . '</td>
                    <td>' . date('d/m/Y H:i', strtotime($formacao['created_at'])) . '</td>
                </tr>';
        }
        $html .= '
            </tbody>
        </table>';
    } else {
        $html .= '<p class="text-center text-danger">Nenhuma formação cadastrada ainda.</p>';
    }

    $html .= '
        <h2>Unidades com Equipamentos</h2>
        <p><strong>Total de Unidades com Equipamentos:</strong> ' . count($unidades_equipamentos) . '</p>';
    
    if (count($unidades_equipamentos) > 0) {
        $html .= '
        <table>
            <thead>
                <tr>
                    <th>Unidade Escolar</th>
                    <th>Total de Equipamentos</th>
                    <th>Quantidade Total</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($unidades_equipamentos as $unidade) {
            $html .= '
                <tr>
                    <td><strong>' . htmlspecialchars($unidade['nome_escola']) . '</strong></td>
                    <td>' . $unidade['total_equipamentos'] . '</td>
                    <td>' . ($unidade['quantidade_total'] ?: 0) . '</td>
                </tr>';
        }
        $html .= '
            </tbody>
        </table>';
    } else {
        $html .= '<p class="text-center text-danger">Nenhuma unidade com equipamentos cadastrada ainda.</p>';
    }

    $html .= '
    </body>
    </html>';

    // Configurar dompdf
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('relatorio_edutec.pdf', ['Attachment' => true]);
    exit;
}

include 'header.php';
?>

<div class="container mt-5">
    <!-- Botão para salvar em PDF -->
    <div class="d-flex justify-content-end mb-4">
        <a href="?export=pdf" class="btn btn-success"><i class="fas fa-file-pdf me-2"></i>Salvar em PDF</a>
    </div>

    <!-- Card para Formações Realizadas -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white" data-bs-toggle="collapse" data-bs-target="#formacoesBody" aria-expanded="false" aria-controls="formacoesBody" role="button">
            <h3 class="card-title mb-0"><i class="fas fa-graduation-cap me-2"></i>Formações Realizadas</h3>
        </div>
        <div id="formacoesBody" class="collapse">
            <div class="card-body">
                <p class="card-text"><strong>Total de Formações:</strong> <?php echo $total_formacoes; ?></p>
                <?php if ($total_formacoes > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nome da Formação</th>
                                    <th>Data Início</th>
                                    <th>Data Fim</th>
                                    <th>Unidade Escolar</th>
                                    <th>Descrição</th>
                                    <th>Documento</th>
                                    <th>Fotos</th>
                                    <th>Cadastrado em</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($formacoes as $formacao): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($formacao['nome_formacao']); ?></strong></td>
                                        <td><?php echo date('d/m/Y', strtotime($formacao['data_inicio'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($formacao['data_fim'])); ?></td>
                                        <td><?php echo htmlspecialchars($formacao['nome_escola']); ?></td>
                                        <td>
                                            <?php 
                                            $descricao = htmlspecialchars($formacao['descricao']);
                                            echo strlen($descricao) > 100 ? substr($descricao, 0, 100) . '...' : $descricao;
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($formacao['documento_frequencia'])): ?>
                                                <a href="<?php echo htmlspecialchars($formacao['documento_frequencia']); ?>" target="_blank">Ver PDF</a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php 
                                            $fotos = json_decode($formacao['fotos'] ?? '[]', true);
                                            if (!empty($fotos)): ?>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fotosModal<?php echo $formacao['id_formacao']; ?>">Ver Fotos</a>
                                                <!-- Modal para exibir fotos -->
                                                <div class="modal fade" id="fotosModal<?php echo $formacao['id_formacao']; ?>" tabindex="-1" aria-labelledby="fotosModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="fotosModalLabel">Fotos da Formação: <?php echo htmlspecialchars($formacao['nome_formacao']); ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php foreach ($fotos as $foto): ?>
                                                                    <img src="<?php echo htmlspecialchars($foto); ?>" class="img-fluid mb-2" alt="Foto da formação" style="max-width: 100%;">
                                                                <?php endforeach; ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($formacao['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> Nenhuma formação cadastrada ainda.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Card para Unidades com Equipamentos -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white" data-bs-toggle="collapse" data-bs-target="#equipamentosBody" aria-expanded="false" aria-controls="equipamentosBody" role="button">
            <h3 class="card-title mb-0"><i class="fas fa-desktop me-2"></i>Unidades com Equipamentos</h3>
        </div>
        <div id="equipamentosBody" class="collapse">
            <div class="card-body">
                <p class="card-text"><strong>Total de Unidades com Equipamentos:</strong> <?php echo count($unidades_equipamentos); ?></p>
                <?php if (count($unidades_equipamentos) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Unidade Escolar</th>
                                    <th>Total de Equipamentos</th>
                                    <th>Quantidade Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($unidades_equipamentos as $unidade): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($unidade['nome_escola']); ?></strong></td>
                                        <td><?php echo $unidade['total_equipamentos']; ?></td>
                                        <td><?php echo $unidade['quantidade_total'] ?: 0; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> Nenhuma unidade com equipamentos cadastrada ainda.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
$conn->close();
?>