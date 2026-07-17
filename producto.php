<?php
session_start();
require_once 'config/init.php';

// Validar que el ID exista
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];
$res = $conexion->query("SELECT * FROM productos WHERE id = $id");
$p = $res->fetch_assoc();

// Si el producto no existe, redirigir
if (!$p) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificamos stock real antes de añadir
    if ($p['stock'] > 0) {
        $_SESSION['carrito'][] = $id;
        header("Location: carrito.php");
        exit();
    } else {
        $error = "Lo sentimos, este producto está agotado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <title><?php echo htmlspecialchars($p['nombre']); ?></title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container" style="padding-top: 40px;">
        <div class="detalle-producto" style="display: flex; gap: 40px; background: white; padding: 30px; border-radius: 15px;">
            <div>
                <h2><?php echo htmlspecialchars($p['nombre']); ?></h2>
                <p style="font-size: 1.2rem; color: #666;"><?php echo htmlspecialchars($p['descripcion']); ?></p>
                <p style="font-size: 1.8rem; color: var(--accent); font-weight: bold;">
                    <?php echo formatoPrecio($p['precio']); ?>
                </p>
                <p>Stock disponible: <strong><?php echo $p['stock']; ?></strong></p>

                <?php if ($p['stock'] > 0): ?>
                    <form method="POST">
                        <button type="submit" class="btn-carrito">Agregar al Carrito</button>
                    </form>
                <?php else: ?>
                    <button class="btn-carrito" disabled style="background: #ccc;">Agotado</button>
                <?php endif; ?>

                <?php if (isset($error)) echo "<p style='color:red; margin-top:10px;'>$error</p>"; ?>
            </div>
        </div>
    </main>
</body>
</html>