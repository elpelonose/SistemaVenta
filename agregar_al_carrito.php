<?php
session_start();
require_once 'config/init.php'; // Usamos nuestro archivo de inicialización centralizado

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // 1. Consultar el stock actual
    $query = $conexion->prepare("SELECT stock FROM productos WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $resultado = $query->get_result();
    $producto = $resultado->fetch_assoc();

    // 2. Validar que el producto exista y tenga stock
    if ($producto && $producto['stock'] > 0) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Agregamos el ID al carrito
        $_SESSION['carrito'][] = $id;
        
        // Redirigimos al carrito con éxito
        header("Location: carrito.php");
    } else {
        // Redirigimos al inicio con un mensaje de error si no hay stock
        header("Location: index.php?error=sin_stock");
    }
} else {
    // Si no hay ID, volvemos a la tienda
    header("Location: index.php");
}
exit();
?>