<?php
session_start();
// Protección de acceso (reemplaza 'auth.php' si ya tienes el inicio de sesión ahí)
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../login.php");
    exit();
}

include '../config/db.php';

// Validamos que el ID exista y sea numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Ejecutamos la eliminación
    $stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Siempre redirigimos al panel, ocurra o no la eliminación
header("Location: index.php");
exit();
?>