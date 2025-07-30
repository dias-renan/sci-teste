<?php
$host = 'mysql';
$dbname = 'testdb';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS mensagens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        texto VARCHAR(255) NOT NULL
    )");

    echo "Conexão com banco de dados bem-sucedida e tabela criada!";
} catch (PDOException $e) {
    echo "Erro na conexão com o banco: " . $e->getMessage();
}
?>
