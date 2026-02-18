<?php
include '../config/db.php';
include '../includes/header.php';

// SEGURIDAD: Solo Admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// CONSULTA
// Seleccionamos TODAS las categorías de la tabla
$sql = "SELECT * FROM categorias ORDER BY id ASC";
$result = mysqli_query($conexion, $sql);
?>

<main class="container">
    <h2>Gestión de Categorías</h2>
    <a href="crear_categoria.php" class="btn" style="margin-bottom: 20px; display:inline-block;">+ Nueva Categoría</a>

    <table class="table-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td>
                    <a href="editar_categoria.php?id=<?php echo $row['id']; ?>" class="btn-sm">Editar</a>
                    <a href="eliminar_categoria.php?id=<?php echo $row['id']; ?>" class="btn-sm btn-danger" onclick="return confirm('¿Seguro? Esto eliminará todos los productos de esta categoría.');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<style>
    .table-admin {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background: white;
    }
    .table-admin th, .table-admin td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .btn-sm {
        padding: 5px 10px;
        font-size: 0.9rem;
        border-radius: 4px;
        text-decoration: none;
        color: white;
        background-color: #395740 !important; /* Verde medio (Hex directo) */
        transition: background 0.3s;
    }
    .btn-sm:hover {
        background-color: #1b3022 !important; /* Verde oscuro (Hex directo) */
    }
    .btn-danger {
        background-color: #e74c3c !important;
    }
    .btn-danger:hover {
        background-color: #c0392b !important;
    }
</style>
</body>
</html>
