<?php
session_start();

if (isset($_GET['index'])) {
    $index = $_GET['index'];
    
    // Eliminamos el elemento específico del array usando el índice
    if (isset($_SESSION['carrito'][$index])) {
        unset($_SESSION['carrito'][$index]);
        
        // Reorganizamos el array para que no queden huecos
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}

header("Location: carrito.php");
exit();
?>