<?php
require_once 'config/init.php';
// Nota: session_start() ya está en el header.php que incluimos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Mi Tienda Online  </title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <h1>BIENBENIADO</h1>
    <main class="container">
        <!-- Hero Section Dinámico -->
        <section class="hero" style="padding: 40px 0; text-align: center;">
            <h1>
                <?php 
                if(isset($_SESSION['cliente_nombre'])) {
                    echo "¡Bienvenido de nuevo, " . htmlspecialchars($_SESSION['cliente_nombre']) . "!";
                } elseif(isset($_SESSION['admin_login'])) {
                    echo "Panel de Administración";
                } else {
                    echo "Bienvenido a nuestra tienda";
                }
                ?>
            </h1>
            <p>Los mejores productos a tu alcance.</p>
        </section>

        <!-- Notificaciones de sistema -->
        <?php if(isset($_GET['compra']) && $_GET['compra'] == 'exitosa'): ?>
            <div style="background: #3f02e6; color: white; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
                ¡Gracias por tu compra! Tu pedido ha sido procesado con éxito Danos mas dinero  .
            </div>
        <?php endif; ?>

        <div class="grid-productos">
            <?php
            $res = $conexion->query("SELECT * FROM productos WHERE stock > 0");
            
            if ($res->num_rows > 0) {
                while($row = $res->fetch_assoc()): ?>
                    <div class="card" style="border: 1px solid #ff1818; padding: 20px; border-radius: 10px; transition: 0.3s;">
                        <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
                        <p style="font-weight: bold; color: var(--accent);">Precio: <?php echo formatoPrecio($row['precio']); ?></p>
                        
                        <a href="producto.php?id=<?php echo $row['id']; ?>" class="btn-ver" style="display: block; margin-top: 15px; text-align: center;">Ver Detalles</a>
                        
                        <!-- Opción de edición rápida para el Administrador -->
                        <?php if(isset($_SESSION['admin_login'])): ?>
                            <a href="admin/editar.php?id=<?php echo $row['id']; ?>" style="display: block; margin-top: 10px; text-align: center; color: #e67e22; font-size: 0.9rem;">Editar Producto</a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; 
            } else {
                echo "<p style='text-align:center;'>No hay productos disponibles por el momento.</p>";
            }
            ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>