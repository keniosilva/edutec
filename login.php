<?php
session_start();
require_once "conexao.php";

// Inicializar variáveis
$error = "";
$success = "";

// Habilitar logs de erro para debug
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
error_reporting(E_ALL);

// Gerar token CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Função para determinar a página de redirecionamento baseada no usuário
 * @param string $login
 * @param int $id_cidade
 * @param string $nome_cidade
 * @return string
 */
function getRedirectPage($login, $id_cidade, $nome_cidade = '') {
    // Se for admin, redirecionar para dashboard
    if (strtolower($login) === 'admin') {
        return 'dashboard.php';
    }
    
    // Para outros usuários, redirecionar para home.php
    return 'home.php';
}

// Processar login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "login") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erro de validação CSRF. Tente novamente.";
    } else {
        $login = trim($_POST["login"] ?? '');
        $senha = $_POST["senha"] ?? '';

        if (empty($login) || empty($senha)) {
            $error = "Usuário e senha são obrigatórios!";
        } else {
            try {
                // Buscar usuário com informações da cidade
                $sql = "SELECT u.id_usuario, u.nome, u.login, u.senha, u.cidade, u.id_cidade, c.nome_cidade 
                        FROM usuario u 
                        LEFT JOIN cidades c ON u.id_cidade = c.id_cidade 
                        WHERE u.login = ? AND u.status = 'ativo'";
                
                $user = fetchOne($sql, [$login]);

                if ($user && password_verify($senha, $user["senha"])) {
                    // Login bem-sucedido
                    $_SESSION["user"] = $user["nome"];
                    $_SESSION["user_id"] = $user["id_usuario"];
                    $_SESSION["user_login"] = $user["login"];
                    $_SESSION["user_cidade"] = $user["cidade"] ?? '';
                    $_SESSION["user_id_cidade"] = $user["id_cidade"] ?? null;
                    $_SESSION["user_nome_cidade"] = $user["nome_cidade"] ?? '';
                    $_SESSION["is_admin"] = (strtolower($user["login"]) === 'admin');
                    
                    // Registrar log de login
                    $log_sql = "INSERT INTO log_sistema (tabela_afetada, acao, usuario) VALUES (?, ?, ?)";
                    executeQuery($log_sql, ['usuario', 'LOGIN', $user["nome"]]);
                    
                    // Redirecionar baseado no tipo de usuário
                    $redirect_page = getRedirectPage($user["login"], $user["id_cidade"], $user["cidade"]);
                    header("Location: " . $redirect_page);
                    exit;
                } else {
                    $error = "login_failed";
                }
            } catch (Exception $e) {
                $error = "Erro no login: " . $e->getMessage();
                error_log("Erro no login: " . $e->getMessage());
            }
        }
    }
}

// Processar cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "register") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erro de validação CSRF. Tente novamente.";
    } else {
        $nome = trim($_POST["nome"] ?? '');
        $login = trim($_POST["login"] ?? '');
        $senha = $_POST["senha"] ?? '';
        $confirmar_senha = $_POST["confirmar_senha"] ?? '';
        $id_cidade = intval($_POST["id_cidade"] ?? 0);

        if (empty($nome) || empty($login) || empty($senha) || empty($confirmar_senha) || $id_cidade <= 0) {
            $error = "Todos os campos obrigatórios devem ser preenchidos!";
        } elseif ($senha !== $confirmar_senha) {
            $error = "As senhas não coincidem!";
        } elseif (strlen($senha) < 8) {
            $error = "A senha deve ter pelo menos 8 caracteres!";
        } else {
            try {
                // Verificar se login já existe
                $check_sql = "SELECT COUNT(*) as count FROM usuario WHERE login = ?";
                $check_result = fetchOne($check_sql, [$login]);
                
                if ($check_result['count'] > 0) {
                    $error = "Este login já está em uso!";
                } else {
                    // Buscar nome da cidade
                    $cidade_sql = "SELECT nome_cidade FROM cidades WHERE id_cidade = ?";
                    $cidade_result = fetchOne($cidade_sql, [$id_cidade]);
                    $nome_cidade = $cidade_result ? $cidade_result['nome_cidade'] : '';
                    
                    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                    
                    // Inserir usuário
                    $insert_sql = "INSERT INTO usuario (nome, login, senha, cidade, id_cidade, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
                    $result = executeQuery($insert_sql, [$nome, $login, $senha_hash, $nome_cidade, $id_cidade]);
                    
                    if ($result) {
                        $success = "Usuário cadastrado com sucesso!";
                        error_log("Usuário cadastrado: " . $nome . " - " . $login . " - Cidade: " . $nome_cidade);
                        
                        // Registrar log de cadastro
                        $log_sql = "INSERT INTO log_sistema (tabela_afetada, acao, usuario) VALUES (?, ?, ?)";
                        executeQuery($log_sql, ['usuario', 'INSERT', $nome]);
                    } else {
                        $error = "Erro ao inserir usuário no banco de dados.";
                    }
                }
            } catch (Exception $e) {
                $error = "Erro ao cadastrar usuário: " . $e->getMessage();
                error_log("Erro no cadastro: " . $e->getMessage());
            }
        }
    }
}

// Processar alteração de senha
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "change_password") {
    if (!isset($_SESSION["user_id"])) {
        $error = "Você precisa estar logado para alterar a senha!";
    } elseif (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erro de validação CSRF. Tente novamente.";
    } else {
        $senha_atual = $_POST["senha_atual"] ?? '';
        $nova_senha = $_POST["nova_senha"] ?? '';
        $confirmar_nova_senha = $_POST["confirmar_nova_senha"] ?? '';

        if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_nova_senha)) {
            $error = "Todos os campos são obrigatórios!";
        } elseif ($nova_senha !== $confirmar_nova_senha) {
            $error = "As novas senhas não coincidem!";
        } elseif (strlen($nova_senha) < 8) {
            $error = "A nova senha deve ter pelo menos 8 caracteres!";
        } else {
            try {
                $user_sql = "SELECT senha FROM usuario WHERE id_usuario = ?";
                $user = fetchOne($user_sql, [$_SESSION["user_id"]]);

                if ($user && password_verify($senha_atual, $user["senha"])) {
                    $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                    
                    $update_sql = "UPDATE usuario SET senha = ? WHERE id_usuario = ?";
                    executeQuery($update_sql, [$nova_senha_hash, $_SESSION["user_id"]]);
                    
                    $success = "Senha alterada com sucesso!";
                    
                    // Registrar log de alteração de senha
                    $log_sql = "INSERT INTO log_sistema (tabela_afetada, acao, usuario) VALUES (?, ?, ?)";
                    executeQuery($log_sql, ['usuario', 'UPDATE', $_SESSION["user"]]);
                } else {
                    $error = "Senha atual incorreta!";
                }
            } catch (Exception $e) {
                $error = "Erro ao alterar senha: " . $e->getMessage();
                error_log("Erro na alteração de senha: " . $e->getMessage());
            }
        }
    }
}

// Consultar cidades disponíveis no banco
try {
    $cidades_sql = "SELECT id_cidade, nome_cidade FROM cidades WHERE ativo = 1 ORDER BY nome_cidade";
    $cidades_disponiveis = fetchAll($cidades_sql);
} catch (Exception $e) {
    $error = "Erro ao carregar cidades: " . $e->getMessage();
    error_log("Erro ao carregar cidades: " . $e->getMessage());
    $cidades_disponiveis = []; // Fallback para array vazio
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login e Cadastro - EDUTEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0px 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 450px;
            box-sizing: border-box;
            backdrop-filter: blur(10px);
        }

        .logo {
            max-width: 200px;
            width: 100%;
            height: auto;
            margin-bottom: 20px;
            cursor: pointer;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1.5rem;
                margin: 1rem;
            }
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            border: none;
            backdrop-filter: blur(10px);
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }

        .nav-tabs .nav-link {
            color: #495057;
            border-radius: 10px 10px 0 0;
        }

        .nav-tabs .nav-link.active {
            color: #667eea;
            font-weight: bold;
            background-color: rgba(102, 126, 234, 0.1);
        }

        .cidade-info {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border: 1px solid #667eea;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        .admin-info {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffc107;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 0.9em;
            color: #856404;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
        }

        .alert-success {
            background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
            color: white;
        }

        .edutec-title {
            color: #667eea;
            font-weight: bold;
            font-size: 2rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .subtitle {
            color: #6c757d;
            margin-bottom: 30px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="login-container">
        <h1 class="edutec-title">EDUTEC</h1>
        <p class="subtitle">Sistema de Gestão Educacional</p>
        
        <!-- Informação sobre redirecionamento por cidade -->
        <div class="cidade-info">
            <strong>🏙️ Sistema Multi-Cidade</strong><br>
            Após o login, você será direcionado para a página principal que exibirá dados específicos da sua cidade.
        </div>

        <!-- Informação especial para admin -->
        <div class="admin-info">
            <strong>👑 Acesso Administrativo</strong><br>
            Usuários administradores têm acesso ao dashboard com seleção de cidades.
        </div>
        
        <!-- Abas para Login, Cadastro e Alterar Senha -->
        <ul class="nav nav-tabs mb-3" id="authTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">🔐 Login</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">📝 Cadastro</button>
            </li>
            <?php if (isset($_SESSION["user_id"])): ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="change-password-tab" data-bs-toggle="tab" data-bs-target="#change-password" type="button" role="tab" aria-controls="change-password" aria-selected="false">🔑 Alterar Senha</button>
            </li>
            <?php endif; ?>
        </ul>

        <div class="tab-content" id="authTabContent">
            <!-- Formulário de Login -->
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                <?php if ($error && (!isset($_POST["action"]) || $_POST["action"] == "login")): ?>
                    <div class="alert alert-danger text-center" id="login-error">
                        <?php 
                        if ($error === "login_failed") {
                            echo "❌ Credenciais inválidas! Verifique seu usuário e senha.";
                        } else {
                            echo htmlspecialchars($error);
                        }
                        ?>
                    </div>
                <?php endif; ?>
                <?php if ($success && isset($_POST["action"]) && $_POST["action"] == "register"): ?>
                    <div class="alert alert-success text-center"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <div class="mb-3">
                        <label class="form-label">Usuário</label>
                        <input type="text" name="login" class="form-control" required autofocus value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>" placeholder="Digite seu usuário (ex: admin)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" required placeholder="Digite sua senha">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>

            <!-- Formulário de Cadastro -->
            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                <?php if ($error && isset($_POST["action"]) && $_POST["action"] == "register"): ?>
                    <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if ($success && isset($_POST["action"]) && $_POST["action"] == "register"): ?>
                    <div class="alert alert-success text-center"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="action" value="register">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <div class="mb-3">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" name="nome" class="form-control" required value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Usuário</label>
                        <input type="text" name="login" class="form-control" required value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cidade</label>
                        <select name="id_cidade" class="form-control" required>
                            <option value="">Selecione uma cidade</option>
                            <?php foreach ($cidades_disponiveis as $cidade): ?>
                                <option value="<?php echo $cidade['id_cidade']; ?>" <?php echo (isset($_POST['id_cidade']) && $_POST['id_cidade'] == $cidade['id_cidade']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cidade['nome_cidade']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha (mínimo 8 caracteres)</label>
                        <input type="password" name="senha" class="form-control" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Senha</label>
                        <input type="password" name="confirmar_senha" class="form-control" required minlength="8">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                </form>
            </div>

            <?php if (isset($_SESSION["user_id"])): ?>
            <!-- Formulário de Alteração de Senha -->
            <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                <?php if ($error && isset($_POST["action"]) && $_POST["action"] == "change_password"): ?>
                    <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if ($success && isset($_POST["action"]) && $_POST["action"] == "change_password"): ?>
                    <div class="alert alert-success text-center"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="action" value="change_password">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <div class="mb-3">
                        <label class="form-label">Senha Atual</label>
                        <input type="password" name="senha_atual" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nova Senha (mínimo 8 caracteres)</label>
                        <input type="password" name="nova_senha" class="form-control" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Nova Senha</label>
                        <input type="password" name="confirmar_nova_senha" class="form-control" required minlength="8">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Alterar Senha</button>
                    <div class="mt-3">
                        <a href="<?php echo ($_SESSION['is_admin'] ?? false) ? 'dashboard.php' : 'home.php'; ?>" class="btn btn-secondary w-100">Voltar ao Sistema</a>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide error messages after 5 seconds
            const errorAlert = document.getElementById('login-error');
            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                }, 5000);
            }
            
            // Validação para o formulário de cadastro
            const registerForm = document.querySelector('#register form');
            if (registerForm) {
                const senhaInput = registerForm.querySelector('input[name="senha"]');
                const confirmarSenhaInput = registerForm.querySelector('input[name="confirmar_senha"]');
                
                if (senhaInput && confirmarSenhaInput) {
                    function validatePasswords() {
                        if (senhaInput.value !== confirmarSenhaInput.value) {
                            confirmarSenhaInput.setCustomValidity('As senhas não coincidem');
                        } else {
                            confirmarSenhaInput.setCustomValidity('');
                        }
                    }
                    
                    senhaInput.addEventListener('input', validatePasswords);
                    confirmarSenhaInput.addEventListener('input', validatePasswords);
                }
            }
            
            // Validação para o formulário de alteração de senha
            const changePasswordForm = document.querySelector('#change-password form');
            if (changePasswordForm) {
                const novaSenhaInput = changePasswordForm.querySelector('input[name="nova_senha"]');
                const confirmarNovaSenhaInput = changePasswordForm.querySelector('input[name="confirmar_nova_senha"]');
                
                if (novaSenhaInput && confirmarNovaSenhaInput) {
                    function validateNewPasswords() {
                        if (novaSenhaInput.value !== confirmarNovaSenhaInput.value) {
                            confirmarNovaSenhaInput.setCustomValidity('As senhas não coincidem');
                        } else {
                            confirmarNovaSenhaInput.setCustomValidity('');
                        }
                    }
                    
                    novaSenhaInput.addEventListener('input', validateNewPasswords);
                    confirmarNovaSenhaInput.addEventListener('input', validateNewPasswords);
                }
            }
        });
    </script>
</body>
</html>

