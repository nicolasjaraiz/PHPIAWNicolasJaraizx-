<?php
include '../config/db.php';
// session_start();
// NOTA: Como no incluimos header.php aquí (es un script de acción), iniciamos session arriba si no está.
// Pero config/db.php no inicia session.
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Verificamos si nos pasan el ID en la URL (ej: eliminar_producto.php?id=5)
if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // (int) fuerza a que sea un número por seguridad
    
    // ELIMINAR
    // Preparamos la consulta SQL para borrar
    $sql = "DELETE FROM productos WHERE id = $id";
    
    // Ejecutamos
    if (mysqli_query($conexion, $sql)) {
        header("Location: admin_productos.php");
    } else {
        // Enviar a la página de error con mensaje (OJO: error.php está en la raíz)
        header("Location: ../error.php?msg=" . urlencode("Error al eliminar producto: " . mysqli_error($conexion)));
    }
} else {
    // Si no hay ID, volvemos a la lista
    header("Location: admin_productos.php");
}
?>
