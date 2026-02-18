<?php
include 'config/db.php';
include 'includes/header.php';

// VERIFICACIÓN DE SEGURIDAD
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];

// CONSULTA DE FAVORITOS
// Unimos la tabla productos con la tabla favoritos para mostrar SOLO los que el usuario ha guardado.
$sql = "SELECT p.*, f.agregado_el 
        FROM productos p 
        JOIN favoritos f ON p.id = f.producto_id 
        WHERE f.usuario_id = $user_id";
$result = mysqli_query($conexion, $sql);
?>

<main class="container">
    <h2>Mis Productos Favoritos</h2>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="grid-productos">
            <?php while ($prod = mysqli_fetch_assoc($result)): ?>
                <div class="card">
                    <img src="<?php echo $prod['imagen_url']; ?>" alt="<?php echo $prod['nombre']; ?>" onerror="this.src='https://via.placeholder.com/300?text=No+Image'">
                    
                    <div class="card-content">
                        <div class="card-title"><?php echo $prod['nombre']; ?></div>
                        <p><strong>Precio: <?php echo $prod['precio']; ?>€</strong></p>
                        <p style="font-size: 0.8rem; color: #666;">Guardado el: <?php echo $prod['agregado_el']; ?></p>
                        
                        <a href="<?php echo $prod['link_cnfans']; ?>" target="_blank" class="btn" style="background-color: var(--verde-claro);">Ver en CNFans</a>
                        
                        <!-- Opción para quitar de favoritos -->
                        <a href="favoritos_accion.php?action=remove&id=<?php echo $prod['id']; ?>" class="btn" style="background-color: #e74c3c; margin-top: 5px;">Quitar Favorito</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No tienes productos en favoritos todavía.</p>
        <a href="productos.php" class="btn">Ir al Catálogo</a>
    <?php endif; ?>
</main>
</body>
</html>
