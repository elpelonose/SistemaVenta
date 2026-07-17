<?php
session_start();
require_once 'config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ? AND rol = 'cliente'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['cliente_id'] = $user['id'];
        $_SESSION['cliente_nombre'] = $user['nombre'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Credenciales incorrectas o no eres un cliente.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container" style="padding-top: 50px; max-width: 400px;">
        <h2 style="text-align: center; margin-bottom: 20px;">Iniciar Sesión</h2>
        
        <form method="POST" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <?php if(isset($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Contraseña</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <button type="submit" style="width: 100%; background: #27ae60; color: white; padding: 12px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;">
                Ingresar
            </button>
            
            <p style="text-align: center; margin-top: 15px;">
                ¿No tienes cuenta? <a href="registro.php" style="color: #27ae60;">Regístrate aquí</a>
            </p>
        </form>
    </main>
</body>
</html>