<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS colegio_app";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos creada exitosamente o ya existe";
} else {
    echo "Error creando base de datos: " . $conn->error;
}

$conn->close();
?>
