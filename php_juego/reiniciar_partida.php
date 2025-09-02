<?php
session_start();
include '../conexion.php'; 

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../RL/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("DELETE FROM respuestas WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->close();


$stmt = $conn->prepare("DELETE FROM usuario_finales WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->close();


header("Location: escena.php?id=1");
exit;
?>
