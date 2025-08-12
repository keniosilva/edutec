<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EDUTEC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Estilo para a navbar */
        .navbar-nav .nav-link {
            color: white;
            transition: color 0.3s, background-color 0.3s; /* Transição suave */
        }

        /* Efeito ao passar o mouse */
        .navbar-nav .nav-link:hover {
            color: #ffcc00;
            background-color: rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-info bg-info">
    <div class="container">
        <a class="navbar-brand" href="home.php">
            <img src="img/edutec.png" alt="EDUTEC" width="250" height="60">
            <img src="img/ited.png" alt="ITED" width="120" height="80" class="ms-3">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="unidades.php">Unidades</a></li>
                <li class="nav-item"><a class="nav-link" href="equipamentos.php">Equipamentos</a></li>
				<li class="nav-item"><a class="nav-link" href="formacoes.php">Formações</a></li>
                <li class="nav-item"><a class="nav-link" href="relatorios.php">Relatórios</a></li>

                <?php if (isset($_SESSION["user"])): ?> <!-- Se o usuário estiver logado -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white ms-3" href="logout.php">Sair</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
