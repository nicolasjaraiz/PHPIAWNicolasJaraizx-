<?php
include 'config/db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];
$prod_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : 'add'; // 'add' por defecto

if ($prod_id > 0) {
    if ($action == 'remove') {
        // ELIMINAR DE FAVORITOS
        $sql = "DELETE FROM favoritos WHERE usuario_id = $user_id AND producto_id = $prod_id";
        mysqli_query($conexion, $sql);
        // Volvemos a la lista de favoritos
        header("Location: favoritos.php");
    } else {
        // AÑADIR A FAVORITOS
        // Usamos INSERT IGNORE para que si ya existe no de error (simplemente lo ignora)
        // O verificamos antes. Pero IGNORE es más rápido si la PK está bien definida (usuario_id, producto_id).
        $sql = "INSERT INTO favoritos (usuario_id, producto_id) VALUES ($user_id, $prod_id)
                ON DUPLICATE KEY UPDATE agregado_el = CURRENT_DATE"; // Si ya existe, actualizamos fecha
        
        if (mysqli_query($conexion, $sql)) {
            // Volvemos al catálogo (o donde estábamos)
            // Podemos usar $_SERVER['HTTP_REFERER'] para volver atrás
            header("Location: productos.php");
        } else {
             header("Location: error.php?msg=" . urlencode("Error al añadir favorito"));
        }
    }
} else {
    header("Location: productos.php");
}
exit();
?>
