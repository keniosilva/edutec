<?php 
include 'header.php'; 
include 'conexao.php'; // Inclua o arquivo de conexão com o banco de dados
?>

<div class="container mt-4">
    <h2>Unidades Escolares</h2>
    <a href="adicionar_unidade.php" class="btn btn-primary mb-4">Adicionar Unidade</a>

    <div class="row">
        <?php
        // Consulta ao banco de dados
        $sql = "SELECT id_unidade, nome_escola FROM Unidade_Escolar ORDER BY nome_escola ASC;
";
        $result = $conn->query($sql);

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            // Itera sobre os resultados e exibe cada unidade em um card
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-3">';
                echo '<div class="card" style="background-color: rgba(144, 238, 144, 0.3); border: 1px solid #90ee90;">'; // Verde claro quase transparente
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['nome_escola'] . '</h5>';

                echo '<div>';
                echo '<a href="editar_unidade.php?id=' . $row['id_unidade'] . '" class="btn btn-warning btn-sm">Editar</a> ';
                echo '<a href="excluir_unidade.php?id=' . $row['id_unidade'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Tem certeza que deseja excluir?\')">Excluir</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="col-12"><p>Nenhuma unidade escolar encontrada.</p></div>';
        }

        // Fecha a conexão
        $conn->close();
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>