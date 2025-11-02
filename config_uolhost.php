<?php
/**
 * Configurações específicas para UOL Host
 * Windows Server + PHP 8 + MySQL 5.6
 */

// Configurações de ambiente
define('ENVIRONMENT', 'production');
define('DEBUG_MODE', false);

// Configurações de erro para produção
if (!DEBUG_MODE) {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', 'logs/error.log');
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
} else {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

// Configurações de sessão para Windows Server
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Alterar para 1 se usar HTTPS
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');

// Configurações de timezone
date_default_timezone_set('America/Sao_Paulo');

// Configurações de charset para compatibilidade
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// Configurações específicas do UOL Host
define('UOLHOST_MYSQL_VERSION', '5.6');
define('UOLHOST_PHP_VERSION', '8.0');
define('UOLHOST_CHARSET', 'utf8mb4_unicode_ci');

// Configurações de banco de dados UOL Host
define('DB_HOST', 'ited-site.mysql.uhserver.com');
define('DB_NAME', 'edutec');
define('DB_USER', 'edutec');
define('DB_PASS', 'it@d3004');
define('DB_CHARSET', 'utf8mb4');

// Configurações de segurança
define('CSRF_TOKEN_LENGTH', 32);
define('SESSION_TIMEOUT', 7200); // 2 horas
define('PASSWORD_MIN_LENGTH', 8);

// Configurações de upload (se necessário)
define('MAX_UPLOAD_SIZE', '10M');
define('UPLOAD_PATH', 'uploads/');

// Configurações de log
define('LOG_PATH', 'logs/');
define('LOG_LEVEL', 'ERROR'); // ERROR, WARNING, INFO, DEBUG

/**
 * Função para verificar compatibilidade do ambiente
 */
function checkEnvironmentCompatibility() {
    $errors = [];
    
    // Verificar versão do PHP
    if (version_compare(PHP_VERSION, '8.0.0', '<')) {
        $errors[] = 'PHP 8.0+ é necessário. Versão atual: ' . PHP_VERSION;
    }
    
    // Verificar extensões necessárias
    $required_extensions = ['mysqli', 'pdo', 'pdo_mysql', 'mbstring', 'session'];
    foreach ($required_extensions as $ext) {
        if (!extension_loaded($ext)) {
            $errors[] = "Extensão PHP necessária não encontrada: $ext";
        }
    }
    
    // Verificar permissões de diretório
    $required_dirs = [LOG_PATH, UPLOAD_PATH];
    foreach ($required_dirs as $dir) {
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true)) {
                $errors[] = "Não foi possível criar o diretório: $dir";
            }
        } elseif (!is_writable($dir)) {
            $errors[] = "Diretório não tem permissão de escrita: $dir";
        }
    }
    
    return $errors;
}

/**
 * Função para log de erros personalizada
 */
function logError($message, $level = 'ERROR') {
    if (!defined('LOG_PATH') || !is_dir(LOG_PATH)) {
        return false;
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] [$level] $message" . PHP_EOL;
    
    $log_file = LOG_PATH . 'system_' . date('Y-m-d') . '.log';
    return file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);
}

/**
 * Função para sanitizar entrada de dados
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    return $data;
}

/**
 * Função para validar CSRF token
 */
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Função para gerar CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH));
    }
    return $_SESSION['csrf_token'];
}

// Verificar compatibilidade do ambiente na inicialização
$compatibility_errors = checkEnvironmentCompatibility();
if (!empty($compatibility_errors)) {
    if (DEBUG_MODE) {
        echo '<h3>Erros de Compatibilidade:</h3>';
        echo '<ul>';
        foreach ($compatibility_errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
    } else {
        logError('Erros de compatibilidade: ' . implode(', ', $compatibility_errors));
    }
}
?>

