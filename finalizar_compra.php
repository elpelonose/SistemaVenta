<?php
session_start();
require_once 'config/init.php'; // Usamos nuestra inicialización central

if (!empty($_SESSION['carrito'])) {
    $total = 0;
    
    // 1. Calculamos total y validamos stock de todos los items
    foreach ($_SESSION['carrito'] as $id) {
        $res = $conexion->query("SELECT precio, stock FROM productos WHERE id = $id");
        $p = $res->fetch_assoc();
        
        if ($p && $p['stock'] > 0) {
            $total += $p['precio'];
        } else {
            // Si algún producto se agotó antes de finalizar, redirigimos
            header("Location: carrito.php?error=stock_agotado");
            exit();
        }
    }

    // 2. Insertar pedido
    $lista_productos = implode(",", $_SESSION['carrito']); 
    $usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 1; // ID de usuario o 1 por defecto
    
    $stmt = $conexion->prepare("INSERT INTO pedidos (usuario_id, productos, total) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $usuario_id, $lista_productos, $total); // 'd' para double/decimal
    $stmt->execute();

    // 3. ACTUALIZAR STOCK (Descontar 1 unidad por cada producto comprado)
    foreach ($_SESSION['carrito'] as $id) {
        $conexion->query("UPDATE productos SET stock = stock - 1 WHERE id = $id");
    }

    // 4. Vaciar carrito y finalizar
    unset($_SESSION['carrito']);
    header("Location: index.php?compra=exitosa");
    exit();
} else {
    header("Location: carrito.php");
    exit();
}