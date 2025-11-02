<?php
// Verificar se a sessão já foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="home.php">EDUTEC</a>
            
            <?php if (isset($_SESSION["user"])): ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">🏠 Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="unidades.php">🏫 Unidades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="equipamentos.php">💻 Equipamentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="formacoes.php">📚 Formações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="visitas.php">🚶 Visitas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="relatorios.php">📊 Relatórios</a>
                        </li>
                        <?php if (isset($_SESSION["user_tipo"]) && $_SESSION["user_tipo"] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">📈 Dashboard</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    
                    <div class="navbar-nav">
                        <span class="navbar-text me-3">
                            👤 <?php echo htmlspecialchars($_SESSION["user"]); ?>
                            <?php if (isset($_SESSION["user_nome_cidade"])): ?>
                                | 📍 <?php echo htmlspecialchars($_SESSION["user_nome_cidade"]); ?>
                            <?php endif; ?>
                        </span>
                        <a class="nav-link" href="logout.php">🚪 Sair</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

