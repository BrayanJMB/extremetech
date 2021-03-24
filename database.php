<?php
    $server='localhost';
    $username='root';
    $password='';
    $database='extremetech';

    try {
        $conn = new PDO("mysql:host=$server;dbname=$database;",$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    } catch (PDOException $e) {
       die('Conexión Fallida:' . $e->getMessage());
    }
    
?>