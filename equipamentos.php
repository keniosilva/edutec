<?php
//session_start();
include 'header.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Inclusão de Equipamentos</h2>
        </div>
        <div class="card-body">
            <?php
            require 'conexao.php';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nome_equipamento = $_POST['nome_equipamento'];
                $descricao = $_POST['descricao'];
                $data_cadastro = date('Y-m-d');

                if ($conn->connect_error) {
                    die("Erro de conexão: " . $conn->connect_error);
                }

                $sql_verifica = "SELECT id_equipamento FROM equipamentos WHERE nome_equipamento = '$nome_equipamento'";
                $resultado = $conn->query($sql_verifica);

                if ($resultado->num_rows > 0) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">Equipamento com este nome já cadastrado!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                } else {
                    $sql = "INSERT INTO equipamentos (nome_equipamento, descricao, data_cadastro) 
                            VALUES ('$nome_equipamento', '$descricao', '$data_cadastro')";
                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Equipamento salvo com sucesso!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Erro ao salvar: ' . $conn->error . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                    }
                }
            }
            ?>

            <!-- Formulário -->
            <form method="POST" class="mb-4">
                <div class="mb-3">
                    <label for="nome_equipamento" class="form-label fw-bold">Nome do Equipamento</label>
                    <input type="text" class="form-control" id="nome_equipamento" name="nome_equipamento" placeholder="Ex.: Impressora HP" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label fw-bold">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Descreva o equipamento" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Salvar</button>
                <a href="equipamentos.php" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Cancelar</a>
            </form>

            <!-- Lista de Equipamentos -->
            <h3 class="h5 mb-3">Equipamentos Cadastrados</h3>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Nome do Equipamento</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_lista = "SELECT id_equipamento, nome_equipamento, descricao FROM equipamentos ORDER BY data_cadastro DESC";
                        $resultado_lista = $conn->query($sql_lista);

                        if ($resultado_lista->num_rows > 0) {
                            while ($row = $resultado_lista->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['nome_equipamento'] . "</td>";
                                echo "<td>" . $row['descricao'] . "</td>";
                                echo "<td><a href='editar_equipamento.php?id=" . $row['id_equipamento'] . "' class='btn btn-outline-warning btn-sm'><i class='bi bi-pencil'></i> Editar</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center text-muted'>Nenhum equipamento cadastrado.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>