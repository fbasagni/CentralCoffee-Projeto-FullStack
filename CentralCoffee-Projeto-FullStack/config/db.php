<?php
declare(strict_types=1);

/**
 * Retorna uma conexão PDO reutilizável com o banco centralcoffee.
 */
function getConnection(): PDO
{
    static $connection = null;

    if ($connection instanceof PDO) {
        return $connection;
    }

    $host     = '127.0.0.1';
    $dbname   = 'centralcoffee';
    $username = 'root';
    $password = ''; // sem senha no XAMPP
    $port     = 3307; // <<< PORTA DO SEU MYSQL

    // DSN COM PORTA
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

    try {
        $connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return $connection;
    } catch (PDOException $exception) {
        // se quiser debugar mais, pode concatenar a mensagem:
        // die('Erro ao conectar ao banco de dados: ' . $exception->getMessage());
        die('Erro ao conectar ao banco de dados. Verifique as credenciais e tente novamente.');
    }
}
