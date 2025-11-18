<?php
require_once __DIR__ . '/../config.php';
session_start();
include __DIR__ . '/../conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Preparamos la consulta para evitar inyecciones
    $stmt = $conn->prepare("SELECT id, nombre, email, password_hash FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificamos la contraseña
        if (password_verify($password, $usuario['password_hash'])) {
            // Iniciar sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_email'] = $usuario['email'];

            header("Location: " . BASE_URL . "/index.php");
            exit();
        } else {
            header("Location: " . BASE_URL . "/RL/login.php?error=Contraseña incorrecta");
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "/RL/login.php?error=Correo no registrado");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: " . BASE_URL . "/RL/login.php");
    exit();
}
