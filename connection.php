<?php
$DB_severname = 'localhost';
$DB_username = 'root';
$DB_password = '';
$DB_database = 'rentsystem';
try{
    $conn = new PDO("mysql:host=$DB_severname;dbname=$DB_database", $DB_username, $DB_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    echo "資料庫連接失敗" . $e->getMessage();
}

