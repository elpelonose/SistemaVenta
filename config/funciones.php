<?php
// Función para limpiar datos que vienen de formularios (evita ataques XSS)
function limpiar($dato) {
    global $conexion;
    return $conexion->real_escape_string(htmlspecialchars(trim($dato)));
}

// Función para formatear precios siempre igual
function formatoPrecio($precio) {
    return "$" . number_format($precio, 2);
}

// Función para obtener nombre del producto por ID (útil para el carrito)
function obtenerNombreProducto($id) {
    global $conexion;
    $res = $conexion->query("SELECT nombre FROM productos WHERE id = $id");
    $p = $res->fetch_assoc();
    return $p ? $p['nombre'] : "Producto no encontrado";
}
?>