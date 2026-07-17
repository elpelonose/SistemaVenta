<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

$cantidad_carrito = 0;
if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
    $cantidad_carrito = count($_SESSION['carrito']);
}
?>

<header class="main-header">
    <div class="container header-content" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0;">
        <h1 style="cursor: pointer; margin: 0;" onclick="window.location.href='index.php';">Mi Tienda</h1>
        <nav style="display: flex; gap: 15px;">
            <a href="index.php">Inicio</a>
            <a href="carrito.php" style="position: relative;">
                Carrito 
                <span style="background: var(--accent, #e67e22); padding: 2px 8px; border-radius: 50%; font-size: 0.8rem; color: white;">
                    <?php echo $cantidad_carrito; ?>
                </span>
            </a>
            
            <?php if(isset($_SESSION['admin_login'])): ?>
                <!-- Sesión Admin -->
                <a href="admin/index.php" style="font-weight: bold;">Panel Admin</a>
                <a href="logout.php" style="color: #e74c3c;">Salir</a>
            <?php elseif(isset($_SESSION['cliente_id'])): ?>
                <!-- Sesión Cliente -->
                <span style="color: #fff;">Hola, <?php echo htmlspecialchars($_SESSION['cliente_nombre']); ?></span>
                <a href="logout.php" style="color: #e74c3c;">Salir</a>
            <?php else: ?>
                <!-- Invitado -->
                <a href="login_cliente.php" style="font-weight: bold;">Iniciar Sesión</a>
                <a href="registro.php">Registrarse</a>
                <a href="login.php" style="font-size: 0.7rem; opacity: 0.6; align-self: center;">Admin</a>
            <?php endif; ?>
        </nav>
    </div>
</header>