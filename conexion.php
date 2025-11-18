<?php
$host1 = 'localhost';
$usuario1 = 'phpmyadmin';
$clave1 = 'perrunobro2008';
$bd1 = 'juego_decisiones';

$conn = new mysqli($host1, $usuario1, $clave1, $bd1);

if ($conn->connect_error) {

    $host2 = 'localhost';
    $usuario2 = 'root';
    $clave2 = '';
    $bd2 = 'juego_decisiones';
    
    $conn = new mysqli($host2, $usuario2, $clave2, $bd2);

    if ($conn->connect_error) {
        die("Error: No se pudo conectar a ninguna de las bases de datos.");
    }
}
?> 