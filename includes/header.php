<?php
// CABECERA GLOBAL
// Este archivo se "carga" (include) en todas las páginas.
// Es el lugar perfecto para iniciar la sesión una sola vez.

// session_start() es obligatorio para usar variables de $_SESSION.
// Comprobamos si ya hay una sesión activa para no reiniciarla (evitar errores)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DETECTAR UBICACIÓN
// Si estamos dentro de la carpeta 'admin_cat', necesitamos salir un nivel (../)
// para buscar los archivos css, logout, etc.
$in_admin_folder = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin_cat');
$path_prefix = $in_admin_folder ? '../' : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CNFans Catalog</title>
    <!-- El CSS también necesita el prefijo si estamos en una subcarpeta -->
    <link rel="stylesheet" href="<?php echo isset($path_prefix) ? $path_prefix : ''; ?>css/estilo.css">
</head>
<body>
<?php
// (Lógica movida arriba)
?>
<header>
    <nav>
        <div class="logo">
            <strong>CNFans Project</strong>
        </div>
        <div class="menu">
            <!-- Usamos $path_prefix para que los enlaces funcionen desde cualquier carpeta -->
            <a href="<?php echo $path_prefix; ?>index.php">Inicio</a>
            <a href="<?php echo $path_prefix; ?>productos.php">Catálogo</a>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <span>Bienvenid@, <?php echo htmlspecialchars($_SESSION['email']); ?> (<?php echo $_SESSION['rol']; ?>)</span>
                
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <!-- Si ya estamos en admin, enlace directo. Si no, entramos en la carpeta -->
                    <a href="<?php echo $in_admin_folder ? 'admin_panel.php' : 'admin_cat/admin_panel.php'; ?>">Panel Admin</a>
                <?php else: ?>
                    <a href="<?php echo $path_prefix; ?>favoritos.php">Mis Favoritos</a>
                <?php endif; ?>

                <a href="<?php echo $path_prefix; ?>logout.php">Cerrar Sesión</a>
            <?php else: ?>
                <a href="<?php echo $path_prefix; ?>login.php">Iniciar Sesión</a>
                <a href="<?php echo $path_prefix; ?>registro.php">Registrarse</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
<hr>