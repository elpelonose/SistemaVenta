<?php 
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../login.php");
    exit();
}
require_once '../config/init.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock  = $_POST['stock'];
    $categoria_id = (int)$_POST['categoria_id']; // Capturamos la categoría

    $stmt = $conexion->prepare("INSERT INTO productos (nombre, precio, stock, categoria_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdii", $nombre, $precio, $stock, $categoria_id);
    
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Agregar Producto</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="container" style="padding-top: 30px; max-width: 600px;">
        <h2 style="margin-bottom: 20px;">Agregar Nuevo Producto</h2>
        
        <form method="POST" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre del producto</label>
                <input type="text" name="nombre" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <!-- Nuevo Selector de Categorías -->
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Categoría</label>
                <select name="categoria_id" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="">Selecciona una categoría</option>
                    <?php
                    $cat_res = $conexion->query("SELECT * FROM categorias");
                    while($c = $cat_res->fetch_assoc()) {
                        echo "<option value='{$c['id']}'>{$c['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div style="display: flex; gap: 15px;">
                <div style="flex: 1; margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="flex: 1; margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Stock</label>
                    <input type="number" name="stock" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>

            <button type="submit" style="width: 100%; background: #27ae60; color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;">Guardar Producto</button>
        </form>
    </main>
</body>
</html>