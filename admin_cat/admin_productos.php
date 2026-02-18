<?php
include '../config/db.php';
include '../includes/header.php';

// Verificamos que sea administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// CONSULTA DE PRODUCTOS
// Usamos LEFT JOIN para unir productos con categorias.
// LEFT JOIN significa: "Traeme todos los productos, y si tienen categoría, dime su nombre. Si no, déjalo vacío".
// Asignamos 'categoria_nombre' para poder mostrarlo fácilmente en la tabla.
$sql = "SELECT p.*, c.nombre as categoria_nombre FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id";
$result = mysqli_query($conexion, $sql);
?>

<main class="container">
    <h2>Gestión de Productos</h2>
    <a href="crear_producto.php" class="btn" style="margin-bottom: 20px; display:inline-block;">+ Nuevo Producto</a>

    <table class="table-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td>
                    <?php 
                    $ruta_img = $row['imagen_url'];
                    if (strpos($ruta_img, 'http') !== 0) {
                        $ruta_img = '../' . $ruta_img;
                    }
                    ?>
                    <img src="<?php echo $ruta_img; ?>" width="50">
                </td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['categoria_nombre']; ?></td>
                <td><?php echo $row['precio']; ?>€</td>
                <td>
                    <a href="editar_producto.php?id=<?php echo $row['id']; ?>" class="btn-sm">Editar</a>
                    <a href="eliminar_producto.php?id=<?php echo $row['id']; ?>" class="btn-sm btn-danger" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
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
