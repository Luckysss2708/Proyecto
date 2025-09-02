<?php
include '../conexion.php'; 
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../RL/login.php");
    exit();
}
?>

