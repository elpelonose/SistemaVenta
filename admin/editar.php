<?php 
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../login.php");
    exit();
}
require_once '../config/init.php'; 

// Obtenemos el ID de forma segura
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Actualizamos incluyendo categoria_id
    $stmt = $conexion->prepare("UPDATE productos SET nombre=?, precio=?, stock=?, categoria_id=? WHERE id=?");
    $stmt->bind_param("sdiii", $_POST['nombre'], $_POST['precio'], $_POST['stock'], $_POST['categoria_id'], $id);
    $stmt->execute();
    header("Location: index.php");
    exit();
}

$res = $conexion->query("SELECT * FROM productos WHERE id = $id");
$producto = $res->fetch_assoc();

if (!$producto) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Editar Producto</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="container" style="padding-top: 30px; max-width: 600px;">
        <h2 style="margin-bottom: 20px;">Editar Producto</h2>
        
        <form method="POST" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre del producto</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <!-- Selector de categorías para editar -->
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Categoría</label>
                <select name="categoria_id" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                    <?php
                    $cat_res = $conexion->query("SELECT * FROM categorias");
                    while($c = $cat_res->fetch_assoc()) {
                        $selected = ($c['id'] == $producto['categoria_id']) ? 'selected' : '';
                        echo "<option value='{$c['id']}' $selected>{$c['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div style="display: flex; gap: 15px;">
                <div style="flex: 1; margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="flex: 1; margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Stock</label>
                    <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>

            <button type="submit" style="width: 100%; background: #2980b9; color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;">Actualizar Producto</button>
        </form>
        
        <div style="margin-top: 20px; text-align: center;">
            <a href="index.php" style="color: #7f8c8d; text-decoration: none;">Cancelar</a>
        </div>
    </main>
</body>
</html>