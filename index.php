<?php 
// Incluimos el header que ya tiene session_start() y el diseño
include 'includes/header.php'; 
?>

<main class="container">
    <h2>Bienvenido a la Plataforma de Enlaces CNFans</h2>
    <p>Explora nuestra selección de productos curados de los mejores proveedores.</p>

    <?php if (!isset($_SESSION['usuario_id'])): ?>
        <section style="background: #e9f0e9; padding: 20px; border-left: 5px solid var(--verde-medio);">
            <p>Inicia sesión para poder guardar tus productos favoritos y ver los enlaces directos.</p>
            <a href="login.php" class="btn">Ir al Login</a>
        </section>
    <?php else: ?>
        <p>Has iniciado sesión como: <strong><?php echo $_SESSION['rol']; ?></strong></p>
        
        <?php if ($_SESSION['rol'] === 'admin'): ?>
            <div class="role-section admin-welcome">
                <h3>Panel de Control</h3>
                <p>Tienes acceso total para gestionar productos y categorías.</p>
                <a href="/PROJECTE/admin_cat/admin_panel.php" class="btn">Ir al Panel de Administración</a>
            </div>
        <?php else: ?>
            <div class="role-section user-welcome">
                <h3>Tu Espacio</h3>
                <p>Explora el catálogo y guarda tus favoritos.</p>
                <a href="productos.php" class="btn">Ver Catálogo</a>
                <a href="favoritos.php" class="btn" style="background-color: #f39c12;">Mis Favoritos</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <style>
        .role-section {
            margin-top: 20px;
            padding: 20px;
            border-radius: 8px;
            color: white;
        }
        .admin-welcome {
            background-color: var(--verde-oscuro);
        }
        .user-welcome {
            background-color: var(--verde-medio);
        }
    </style>
</main>

</body>
</html>