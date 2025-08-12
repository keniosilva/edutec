<?php
// config/db.php
$host   = 'localhost';
$dbname = 'cris_db';  // Altere para o nome do seu banco de dados
$user   = 'root';     // Altere para o usuário do seu banco de dados
$pass   = 'adm123Info';         // Altere para a senha do seu banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}
?>
