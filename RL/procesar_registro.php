<?php
include '../conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validar email único
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El correo ya está registrado
        header("Location: registro.php?error=El correo ya está en uso.");
        exit();
    }

    // Crear hash de la contraseña
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $hash);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: registro.php?error=Error al registrar usuario.");
        exit();
    }
} else {
    header("Location: registro.php");
    exit();
}
