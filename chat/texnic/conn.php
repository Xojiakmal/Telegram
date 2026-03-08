<?php
$dsn = "mysql:host=localhost;dbname=Imtihon2";
$name = 'root';
$pass = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];
$pdo = new PDO($dsn, $name, $pass, $options);