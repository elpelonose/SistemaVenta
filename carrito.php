<?php
session_start();
require_once 'config/init.php';

// Lógica para eliminar un producto del carrito
if (isset($_GET['eliminar'])) {
    $indice = $_GET['eliminar'];
    unset($_SESSION['carrito'][$indice]);
    // Reindexamos para evitar huecos en el array
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    header("Location: carrito.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Tu Carrito</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container" style="padding-top: 30px;">
        <h2 style="margin-bottom: 20px;">Tu Carrito</h2>
        
        <?php if (!empty($_SESSION['carrito'])): ?>
            <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 2px solid #eee;">
                        <th style="text-align: left; padding: 10px;">Producto</th>
                        <th style="text-align: right; padding: 10px;">Precio</th>
                        <th style="text-align: center; padding: 10px;">Acción</th>
                    </tr>
                    <?php 
                    $total = 0;
                    foreach($_SESSION['carrito'] as $indice => $id): 
                        $res = $conexion->query("SELECT * FROM productos WHERE id = $id");
                        $p = $res->fetch_assoc();
                        if ($p) {
                            $total += $p['precio'];
                    ?>
                    <tr>
                        <td style="padding: 15px; border-bottom: 1px solid #eee;"><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td style="padding: 15px; text-align: right; border-bottom: 1px solid #eee;"><?php echo formatoPrecio($p['precio']); ?></td>
                        <td style="padding: 15px; text-align: center; border-bottom: 1px solid #eee;">
                            <a href="carrito.php?eliminar=<?php echo $indice; ?>" style="color: #e74c3c; text-decoration: none; font-size: 0.9rem;">Eliminar</a>
                        </td>
                    </tr>
                    <?php 
                        }
                    endforeach; 
                    ?>
                </table>
                
                <div style="margin-top: 25px; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0;">Total: <?php echo formatoPrecio($total); ?></h3>
                    <a href="#" class="btn-carrito">Finalizar Compra</a>
                </div>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; background: white; border-radius: 15px;">
                <p>Tu carrito está vacío.</p>
                <a href="index.php" style="color: var(--accent); font-weight: bold; text-decoration: none;">Ir a comprar productos</a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>