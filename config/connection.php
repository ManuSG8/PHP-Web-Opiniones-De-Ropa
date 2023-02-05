<?php

$server = 'db-pdo';
$user = 'tarefa';
$pass = 'Tarefa4.7';
$bbdd = 'tarefa4.7';

    try {
        $connection = new PDO(
            "mysql:host=$server;dbname=$bbdd;charset=utf8mb4",
            $user,
            $pass
        );
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo "Houbo un erro na conexión:\n\n" . $e->getMessage();
    }

?>
