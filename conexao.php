<?php
/**
 * Arquivo de conexão com o banco de dados
 * Configurado para UOL Host - Windows Server
 * MySQL 5.6 com charset utf8mb4_unicode_ci
 */

// Configurações do banco de dados UOL Host
$servername = "ited-site.mysql.uhserver.com";
$username = "edutec";
$password = "It@d3004";
$dbname = "edutec";

// Configurar charset para UTF-8
$charset = 'utf8mb4';

// Configurar DSN para PDO
$dsn = "mysql:host=$servername;dbname=$dbname;charset=$charset";

// Opções do PDO para melhor compatibilidade
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
];

try {
    // Conexão PDO (preferencial para PHP 8)
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // Conexão MySQLi (fallback para compatibilidade)
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verificar conexão MySQLi
    if ($conn->connect_error) {
        throw new Exception("Falha na conexão MySQLi: " . $conn->connect_error);
    }
    
    // Configurar charset para MySQLi
    $conn->set_charset("utf8mb4");
    
} catch (PDOException $e) {
    // Log do erro PDO
    error_log("Erro PDO: " . $e->getMessage());
    die("Erro na conexão com o banco de dados. Tente novamente mais tarde.");
} catch (Exception $e) {
    // Log do erro MySQLi
    error_log("Erro MySQLi: " . $e->getMessage());
    die("Erro na conexão com o banco de dados. Tente novamente mais tarde.");
}

/**
 * Função para obter a conexão PDO
 * @return PDO
 */
function getPDO() {
    global $pdo;
    return $pdo;
}

/**
 * Função para obter a conexão MySQLi
 * @return mysqli
 */
function getMySQLi() {
    global $conn;
    return $conn;
}

/**
 * Função para executar queries com segurança
 * @param string $sql
 * @param array $params
 * @return PDOStatement|false
 */
function executeQuery($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Erro na query: " . $e->getMessage());
        return false;
    }
}

/**
 * Função para buscar um registro
 * @param string $sql
 * @param array $params
 * @return array|false
 */
function fetchOne($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt ? $stmt->fetch() : false;
}

/**
 * Função para buscar múltiplos registros
 * @param string $sql
 * @param array $params
 * @return array
 */
function fetchAll($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt ? $stmt->fetchAll() : [];
}
?>

