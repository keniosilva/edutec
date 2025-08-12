<?php
session_start();
require_once "ad_auth.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Conectar ao Active Directory
    $ldap_conn = ldap_connect(LDAP_SERVER, LDAP_PORT) or die("Erro ao conectar no AD.");
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

    $ldap_user = $username . "@" . LDAP_DOMAIN; // Formato: usuario@dominio.local

    if (@ldap_bind($ldap_conn, $ldap_user, $password)) {
        $_SESSION["user"] = $username;
        header("Location: home.php"); // Redireciona após login bem-sucedido
        exit;
    } else {
        $error = "Usuário ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - EDUTEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-image: url('ited.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-container {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(240, 240, 240, 0.85));
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 90%;
            max-width: 400px;
            box-sizing: border-box;
        }

        .logo {
            max-width: 200px;
            width: 100%;
            height: auto;
            margin-bottom: 20px;
            cursor: pointer;
        }

        @media (max-width: 576px) {
            body {
                background-attachment: scroll; /* Evita bugs em iOS */
                background-size: cover;
            }

            .login-container {
                padding: 1.5rem;
            }
        }

        /* Estilo do modal do Easter Egg */
        .modal-content {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.95), rgba(240, 240, 240, 0.9));
            border-radius: 16px;
            border: none;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="login-container">
        <img src="img/edutec.png" alt="Logo da Empresa" class="logo" id="logo">
        <h4 class="mb-3">🔐 Login</h4>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Usuário</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>

    <!-- Modal do Easter Egg -->
    <div class="modal fade" id="easterEggModal" tabindex="-1" aria-labelledby="easterEggModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="easterEggModalLabel">📢 Cobrança ao Dono!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Oi, chefe! 🧑‍💼 A equipe está cobrando:</p>
                    <ul>
                        <li>Café gourmet na copa! ☕</li>
                        <li>Cadeiras gamers para salvar nossas costas! 💺</li>
                        <li>Bônus de fim de ano generoso! 💰</li>
                        <li>E, quem sabe, um feriado extra? 😎</li>
                    </ul>
                    <p>🥚 Easter Egg descoberto! Parabéns por clicar no logo!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok, vou pensar! 😅</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Easter Egg: Clique 5 vezes no logo para abrir o modal
        document.getElementById('logo').addEventListener('click', (() => {
            let clickCount = 0;
            const maxClicks = 5;
            return () => {
                clickCount++;
                if (clickCount >= maxClicks) {
                    const modal = new bootstrap.Modal(document.getElementById('easterEggModal'));
                    modal.show();
                    clickCount = 0; // Reseta após mostrar
                }
            };
        })());
    </script>
</body>
</html>