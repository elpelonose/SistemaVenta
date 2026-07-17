<?php 
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../login.php");
    exit();
}
// Usamos init.php para tener acceso a funciones globales como formatoPrecio()
require_once '../config/init.php';
include '../includes/header.php';
?>

<main class="container" style="padding-top: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Gestión de Pedidos</h2>
        <a href="index.php" style="background: #7f8c8d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Volver al Panel</a>
    </div>

    <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 15px; text-align: left; border-top-left-radius: 10px;">ID Pedido</th>
                    <th style="padding: 15px; text-align: left;">Productos (IDs)</th>
                    <th style="padding: 15px; text-align: right;">Total</th>
                    <th style="padding: 15px; text-align: center; border-top-right-radius: 10px;">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pedidos = $conexion->query("SELECT * FROM pedidos ORDER BY fecha_pedido DESC");
                if ($pedidos->num_rows > 0) {
                    while ($pedido = $pedidos->fetch_assoc()) {
                        echo "<tr style='border-bottom: 1px solid #eee;'>
                                <td style='padding: 15px;'>#{$pedido['id']}</td>
                                <td style='padding: 15px;'>" . htmlspecialchars($pedido['productos']) . "</td>
                                <td style='padding: 15px; text-align: right; font-weight: bold;'>" . formatoPrecio($pedido['total']) . "</td>
                                <td style='padding: 15px; text-align: center; color: #7f8c8d;'>" . htmlspecialchars($pedido['fecha_pedido']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='padding: 20px; text-align: center;'>No hay pedidos registrados aún.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>