<?php
include '../config/db.php';
include '../includes/header.php';

// CONTROL DE ACCESO (SEGURIDAD)
// Verificamos dos cosas:
// 1. !isset(...): Que la variable usuario_id exista (que esté logueado)
// 2. $_SESSION['rol'] !== 'admin': Que su rol sea exactamente 'admin'
// Si no cumple alguna, lo echamos fuera (al login)
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<main class="container">
    <h2>Panel de Administración</h2>
    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['email']); ?></p>

    <div class="admin-dashboard">
        <div class="admin-section">
            <h3>Gestión de Productes</h3>
            <p>Afegeix, edita o elimina productes del catàleg.</p>
            <a href="admin_productos.php" class="btn">Gestionar Productos</a>
        </div>

        <div class="admin-section">
            <h3>Gestión de Categorias</h3>
            <p>Administra las categorías disponibles.</p>
            <a href="admin_categorias.php" class="btn">Gestionar Categorías</a>
        </div>
    </div>
</main>

<style>
    .admin-dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .admin-section {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        text-align: center;
    }
</style>
</body>
</html>
