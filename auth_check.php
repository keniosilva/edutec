<?php
/**
 * Arquivo de verificação de autenticação
 * Inclua este arquivo no início de páginas que requerem login
 */

session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user"])) {
    // Usuário não está logado, redirecionar para login
    header("Location: login.php");
    exit;
}

// Verificar se a sessão não expirou (opcional - 2 horas)
$session_timeout = 2 * 60 * 60; // 2 horas em segundos
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_timeout) {
    // Sessão expirou
    session_unset();
    session_destroy();
    header("Location: login.php?expired=1");
    exit;
}

// Atualizar timestamp da última atividade
$_SESSION['last_activity'] = time();

// Função para verificar se o usuário tem acesso a uma cidade específica
function checkCityAccess($required_city_id = null) {
    if ($required_city_id === null) {
        return true; // Sem restrição de cidade
    }
    
    $user_city_id = $_SESSION["user_id_cidade"] ?? null;
    return $user_city_id == $required_city_id;
}

// Função para obter informações do usuário logado
function getLoggedUser() {
    return [
        'id' => $_SESSION["user_id"] ?? null,
        'nome' => $_SESSION["user"] ?? '',
        'cidade' => $_SESSION["user_cidade"] ?? '',
        'id_cidade' => $_SESSION["user_id_cidade"] ?? null,
        'nome_cidade' => $_SESSION["user_nome_cidade"] ?? ''
    ];
}

// Função para verificar se é administrador (opcional)
function isAdmin() {
    // Implementar lógica de verificação de admin se necessário
    $user = getLoggedUser();
    return in_array(strtolower($user['nome']), ['administrador', 'admin']);
}
?>

