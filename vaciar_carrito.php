<?php
session_start();
// Destruimos la sesión del carrito para vaciarlo
unset($_SESSION['carrito']);
// Regresamos al carrito
header("Location: carrito.php");
exit();
?>