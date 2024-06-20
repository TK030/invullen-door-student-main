<?php


    $host = 'localhost';
    $dbname = 'vrijstelling';
    $username = 'root';
    $password = '';
    $port = 3306;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Fout: " . $e->getMessage();
        exit();
}
