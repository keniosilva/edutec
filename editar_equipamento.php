<?php include 'header.php'; ?>

<div class="container mt-4">
    <h2>Editar Equipamento</h2>

    <?php
    // Inclui o arquivo de conexão
    require 'conexao.php';

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Verifica se o ID foi passado na URL
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo '<div class="alert alert-danger mt-3">Erro: Nenhum equipamento selecionado!</div>';
        include 'footer.php';
        exit;
    }

    $id_equipamento = $_GET['id'];

    // Processa o formulário de edição
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome_equipamento = $_POST['nome_equipamento'];
        $descricao = $_POST['descricao'];

        // Verifica se o nome já existe em outro equipamento
        $sql_verifica = "SELECT id_equipamento FROM equipamentos WHERE nome_equipamento = '$nome_equipamento' AND id_equipamento != $id_equipamento";
        $resultado_verifica = $conn->query($sql_verifica);

        if ($resultado_verifica->num_rows > 0) {
            echo '<div class="alert alert-warning mt-3">Erro: Outro equipamento com este nome já está cadastrado!</div>';
        } else {
            // Atualiza os dados no banco
            $sql = "UPDATE equipamentos SET nome_equipamento = '$nome_equipamento', descricao = '$descricao' WHERE id_equipamento = $id_equipamento";

            if ($conn->query($sql) === TRUE) {
                echo '<div class="alert alert-success mt-3">Equipamento atualizado com sucesso! <a href=\"equipamentos.php\">Voltar à lista</a></div>';
            } else {
                echo '<div class="alert alert-danger mt-3">Erro ao atualizar: ' . $conn->error . '</div>';
            }
        }
    }

    // Carrega os dados do equipamento para edição
    $sql = "SELECT nome_equipamento, descricao FROM equipamentos WHERE id_equipamento = $id_equipamento";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $equipamento = $resultado->fetch_assoc();
    } else {
        echo '<div class="alert alert-danger mt-3">Equipamento não encontrado!</div>';
        include 'footer.php';
        exit;
    }
    ?>

    <!-- Formulário de edição de equipamentos -->
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="nome_equipamento" class="form-label">Nome do Equipamento</label>
            <input type="text" class="form-control" id="nome_equipamento" name="nome_equipamento" value="<?php echo $equipamento['nome_equipamento']; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?php echo $equipamento['descricao']; ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="equipamentos.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <?php $conn->close(); ?>
</div>

<?php include 'footer.php'; ?>