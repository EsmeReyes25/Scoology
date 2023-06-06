<?php 
    $server = 'localhost:8889';
    $username = 'root';
    $password = 'root';
    $database = 'courses_php';

    try {
        $conn = new PDO("mysql:host=$server; dbname=$database;", $username, $password);
    } catch (PDOException $error) {
        die('Connection failed' . $error->getMessage());
    }
?>