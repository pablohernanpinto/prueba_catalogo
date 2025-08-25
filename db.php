<?php 

$host = "localhost"; 
$user = "fonda_user";
$password = "123";
$dbname = "fonda";

//crear conexion

$conn = new mysqli($host, $user, $password, $dbname);

//probar conexion

if($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8"); // para evitar problemas con tildes
?>