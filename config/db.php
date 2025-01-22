<?php
$host = 'localhost';
$dbname = 'my_project_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Ma'lumotlar bazasiga ulanish muvaffaqiyatli!";
} catch (PDOException $e) {
    echo "Ulanishda xato: " . $e->getMessage();
}
