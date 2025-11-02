<?php
session_start();

// Registrar log de logout se usuário estiver logado
if (isset($_SESSION["user"])) {
    require_once "conexao.php";
    
    try {
        $log_sql = "INSERT INTO log_sistema (tabela_afetada, acao, usuario) VALUES (?, ?, ?)";
        executeQuery($log_sql, ['usuario', 'LOGOUT', $_SESSION["user"]]);
    } catch (Exception $e) {
        error_log("Erro ao registrar logout: " . $e->getMessage());
    }
}

// Destruir todas as variáveis de sessão
$_SESSION = array();

// Se é desejado destruir a sessão, também delete o cookie de sessão.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir a sessão
session_destroy();

// Redirecionar para a página de login
header("Location: login.php");
exit;
?>

