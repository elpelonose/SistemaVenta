<?php 
session_start();
// Usamos nuestro archivo de inicio centralizado
require_once 'config/init.php'; 

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Usamos la función limpiar que definimos en funciones.php
    $email = limpiar($_POST['email']);
    $pass = $_POST['password'];

    // Consultamos por email y forzamos el rol 'admin'
    $stmt = $conexion->prepare("SELECT id, password, rol FROM usuarios WHERE email = ? AND rol = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    // Verificamos contraseña
    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['admin_login'] = true;
        $_SESSION['usuario_id'] = $user['id'];
        header("Location: admin/index.php");
        exit();
    } else {
        $error = "Acceso denegado: Credenciales incorrectas o no es administrador.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login Admin</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f7f6;">

    <form method="POST" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 350px;">
        <h2 style="text-align: center; margin-bottom: 20px; color: #2c3e50;">Panel Admin</h2>
        
        <input type="email" name="email" placeholder="Correo electrónico" required 
               style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;">
        
        <input type="password" name="password" placeholder="Contraseña" required 
               style="width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;">
        
        <button type="submit" class="btn" style="width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 5px; cursor: pointer;">Entrar</button>
        
        <?php if(!empty($error)): ?>
            <p style="color: #e74c3c; text-align: center; margin-top: 15px; font-size: 0.9rem;"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>

</body>
</html>