<?php 
session_start();
// Seguridad: solo acceso si estás logueado como admin
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../login.php");
    exit();
}
// Usamos nuestro nuevo sistema de inicialización
require_once '../config/init.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/main.js" defer></script>
    <title>Panel de Control | Administrador</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="container" style="padding-top: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2>Panel de Administración</h2>
            <div>
                <a href="crear.php" style="background: #27ae60; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold;">+ Agregar Producto</a>
                <a href="pedidos.php" style="background: #e67e22; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; margin-left: 10px;">Ver Pedidos</a>
            </div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #f4f7f6;">
                        <th style="padding: 15px; text-align: left;">Producto</th>
                        <th style="padding: 15px; text-align: left;">Categoría</th>
                        <th style="padding: 15px; text-align: left;">Precio</th>
                        <th style="padding: 15px; text-align: left;">Stock</th>
                        <th style="padding: 15px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Usamos un JOIN para mostrar el nombre de la categoría en lugar de solo el ID
                    $res = $conexion->query("SELECT p.*, c.nombre AS categoria_nombre 
                                             FROM productos p 
                                             LEFT JOIN categorias c ON p.categoria_id = c.id");
                    
                    while($row = $res->fetch_assoc()) {
                        echo "<tr style='border-bottom: 1px solid #eee;'>
                                <td style='padding: 15px;'>{$row['nombre']}</td>
                                <td style='padding: 15px; color: #7f8c8d;'>".($row['categoria_nombre'] ?? 'Sin categoría')."</td>
                                <td style='padding: 15px;'>".formatoPrecio($row['precio'])."</td>
                                <td style='padding: 15px;'>{$row['stock']}</td>
                                <td style='padding: 15px; text-align: center;'>
                                    <a href='editar.php?id={$row['id']}' style='color: #2980b9; margin-right: 15px; text-decoration: none; font-weight: bold;'>Editar</a>
                                    <a href='eliminar.php?id={$row['id']}' style='color: #c0392b; text-decoration: none; font-weight: bold;'>Eliminar</a>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>