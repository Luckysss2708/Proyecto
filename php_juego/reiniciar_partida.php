<?php
session_start();
include '../conexion.php'; 

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../RL/login.php");
    exit;
}

header("Location: escena.php?id=1");
exit;
?>