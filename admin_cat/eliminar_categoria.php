<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // ELIMINAR CATEGORÍA
    // Nota Importante: En `database.sql` definimos "ON DELETE CASCADE".
    // Esto significa que si borramos la categoría, MySQL borrará AUTOMÁTICAMENTE
    // todos los productos que pertenezcan a esa categoría.
    $sql = "DELETE FROM categorias WHERE id = $id";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: admin_categorias.php");
    } else {
        header("Location: ../error.php?msg=" . urlencode("Error al eliminar categoría: " . mysqli_error($conexion)));
    }
} else {
    header("Location: admin_categorias.php");
}
?>
