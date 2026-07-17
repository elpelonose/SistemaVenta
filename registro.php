<?php
require_once 'config/init.php';

// Si el usuario ya está logueado, lo enviamos al index
if (isset($_SESSION['cliente_id']) || isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit();
}

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptación segura
    $rol = 'cliente';

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $password, $rol);

    if ($stmt->execute()) {
        header("Location: login_cliente.php?registro=exitoso");
        exit();
    } else {
        $mensaje = "Error al registrarse. Inténtalo de nuevo.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Registro de Cliente</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container" style="padding-top: 50px; max-width: 400px;">
        <h2 style="text-align: center; margin-bottom: 20px;">Crear Cuenta</h2>
        
        <form method="POST" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <?php if($mensaje) echo "<p style='color:red; text-align:center;'>$mensaje</p>"; ?>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre</label>
                <input type="text" name="nombre" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Contraseña</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <button type="submit" style="width: 100%; background: #27ae60; color: white; padding: 12px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;">
                Registrarse
            </button>
        </form>
    </main>
</body>
</html>