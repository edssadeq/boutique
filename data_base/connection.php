<?php
define("LIMIT", 18);
session_start();

$server_name = "localhost";
$db_name = "boutique";
$username = "root";
$password = "";
$pdo_conn = null;
try{
    $pdo_conn = new PDO("mysql:host=$server_name;dbname=$db_name", $username, $password);
    // set the PDO error mode to exception
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e){
    echo "Connection Failed [details : ".$e->getMessage();
}



function closeConnection(PDO  $pdo_conn){
    $pdo_conn = null;
}