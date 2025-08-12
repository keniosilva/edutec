<?php
include 'conexao.php';

$mensagem = "";
$sql_unidades = "SELECT id_unidade, nome_escola FROM unidade_escolar ORDER BY nome_escola";
$result_unidades = $conn->query($sql_unidades);

$unidades = [];
if ($result_unidades->num_rows > 0) {
    while($row = $result_unidades->fetch_assoc()) {
        $unidades[] = $row;
    }
}

// Carregar formações existentes para exibição
$sql_formacoes = "SELECT f.*, u.nome_escola 
                  FROM formacoes f 
                  INNER JOIN unidade_escolar u ON f.id_unidade = u.id_unidade 
                  ORDER BY f.created_at DESC";
$result_formacoes = $conn->query($sql_formacoes);

$formacoes = [];
if ($result_formacoes->num_rows > 0) {
    while($row = $result_formacoes->fetch_assoc()) {
        $formacoes[] = $row;
    }
}

// Lógica para inserir nova formação
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_inicio = $_POST["data_inicio"];
    $data_fim = $_POST["data_fim"];
    $nome_formacao = $_POST["nome_formacao"];
    $descricao = $_POST["descricao"];
    $id_unidade = $_POST["id_unidade"];
    $documento_frequencia = null;
    $fotos = [];

    // Validação básica
    if (strtotime($data_fim) < strtotime($data_inicio)) {
        $mensagem = "<div class='alert alert-danger mt-3' role='alert'>Erro: A data de fim deve ser posterior à data de início!</div>";
    } else {
        // Criar diretório para uploads se não existir
        $upload_dir = 'uploads/formacoes/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Processar upload do documento de frequência (PDF)
        if (isset($_FILES['documento_frequencia']) && $_FILES['documento_frequencia']['error'] == UPLOAD_ERR_OK) {
            $pdf_name = uniqid() . '_' . basename($_FILES['documento_frequencia']['name']);
            $pdf_path = $upload_dir . $pdf_name;
            if (pathinfo($pdf_name, PATHINFO_EXTENSION) == 'pdf' && move_uploaded_file($_FILES['documento_frequencia']['tmp_name'], $pdf_path)) {
                $documento_frequencia = $pdf_path;
            } else {
                $mensagem = "<div class='alert alert-danger mt-3' role='alert'>Erro: Apenas arquivos PDF são permitidos para o documento de frequência!</div>";
            }
        }

        // Processar upload de fotos
        if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
            foreach ($_FILES['fotos']['name'] as $key => $name) {
                if ($_FILES['fotos']['error'][$key] == UPLOAD_ERR_OK) {
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
                        $foto_name = uniqid() . '_' . $name;
                        $foto_path = $upload_dir . $foto_name;
                        if (move_uploaded_file($_FILES['fotos']['tmp_name'][$key], $foto_path)) {
                            $fotos[] = $foto_path;
                        }
                    }
                }
            }
        }

        if (empty($mensagem)) {
            $fotos_json = json_encode($fotos);
            $stmt = $conn->prepare("INSERT INTO formacoes (data_inicio, data_fim, nome_formacao, descricao, id_unidade, documento_frequencia, fotos) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssiss", $data_inicio, $data_fim, $nome_formacao, $descricao, $id_unidade, $documento_frequencia, $fotos_json);

            if ($stmt->execute()) {
                $mensagem = "<div class='alert alert-success mt-3' role='alert'>Nova formação adicionada com sucesso!</div>";
            } else {
                $mensagem = "<div class='alert alert-danger mt-3' role='alert'>Erro ao adicionar formação: " . $stmt->error . "</div>";
            }

            $stmt->close();
        }
    }
}

include 'header.php';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Incluir Nova Formação</h3>
                </div>
                <div class="card-body">
                    <?php echo $mensagem; ?>
                    
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_inicio" class="form-label">Data de Início <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_fim" class="form-label">Data de Fim <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="data_fim" name="data_fim" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nome_formacao" class="form-label">Nome da Formação <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nome_formacao" name="nome_formacao" maxlength="255" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_unidade" class="form-label">Unidade Escolar <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_unidade" name="id_unidade" required>
                                <option value="">Selecione uma unidade escolar...</option>
                                <?php foreach($unidades as $unidade): ?>
                                    <option value="<?php echo $unidade['id_unidade']; ?>">
                                        <?php echo htmlspecialchars($unidade['nome_escola']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" placeholder="Descreva os detalhes da formação..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="documento_frequencia" class="form-label">Documento de Frequência (PDF)</label>
                            <input type="file" class="form-control" id="documento_frequencia" name="documento_frequencia" accept=".pdf">
                        </div>
                        
                        <div class="mb-3">
                            <label for="fotos" class="form-label">Fotos da Formação (JPG/PNG)</label>
                            <input type="file" class="form-control" id="fotos" name="fotos[]" accept=".jpg,.jpeg,.png" multiple>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-secondary me-md-2">Limpar</button>
                            <button type="submit" class="btn btn-primary">Salvar Formação</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Seção para listar formações existentes -->
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Formações Cadastradas</h3>
                </div>
                <div class="card-body">
                    <?php if (count($formacoes) > 0): ?>
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
                                    <?php foreach($formacoes as $formacao): ?>
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
                                                                    <button type "button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    </div>
</div>

<?php
include 'footer.php';
$conn->close();
?>