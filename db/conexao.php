<?php
$host    = 'localhost';
$db      = 'db_intranet'; // Nome da sua base de dados
$user    = 'root';        // Usuário do banco
$pass    = '';            // Senha do banco
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Transforma erros do MySQL em exceções tratáveis
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna dados como array associativo por padrão
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Usa Prepared Statements reais do banco
];

try {
    // Cria a variável $pdo usada por todo o sistema
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}
?>