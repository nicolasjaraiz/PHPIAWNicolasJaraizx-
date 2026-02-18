<?php
include '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];
$sql_prod = "SELECT * FROM productos WHERE id = $id";
$res_prod = mysqli_query($conexion, $sql_prod);
$producto = mysqli_fetch_assoc($res_prod);

if (!$producto) {
    header("Location: admin_productos.php");
    exit();
}

$cats = mysqli_query($conexion, "SELECT * FROM categorias");

// PROCESAR FORMULARIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $desc = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $precio = $_POST['precio'];
    $link = mysqli_real_escape_string($conexion, $_POST['link_cnfans']);
    $genero = $_POST['genero'];
    $categoria_id = $_POST['categoria_id'];

    // Recuperamos la imagen actual por defecto
    $img = $producto['imagen_url'];

    // Si suben nueva imagen, la procesamos
    if (isset($_FILES['imagen_archivo']) && $_FILES['imagen_archivo']['error'] === 0) {
        $directorio = "../uploads/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombre_archivo = time() . "_" . basename($_FILES['imagen_archivo']['name']);
        $ruta_destino = $directorio . $nombre_archivo;

        if (move_uploaded_file($_FILES['imagen_archivo']['tmp_name'], $ruta_destino)) {
            $img = "uploads/" . $nombre_archivo;
        }
    } 
    // Si no suben archivo pero cambian la URL manualmente
    elseif (!empty($_POST['imagen_url'])) {
        $img = mysqli_real_escape_string($conexion, $_POST['imagen_url']);
    }

    $sql = "UPDATE productos SET 
            nombre='$nombre', descripcion='$desc', precio='$precio', 
            link_cnfans='$link', imagen_url='$img', genero='$genero', categoria_id='$categoria_id'
            WHERE id=$id";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: admin_productos.php");
        exit();
    } else {
        $error = "Error al actualizar: " . mysqli_error($conexion);
    }
}
?>

<main class="container">
    <h2>Editar Producto</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

    <form method="POST" action="" class="form-admin" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>

        <label>Descripción:</label>
        <textarea name="descripcion"><?php echo $producto['descripcion']; ?></textarea>

        <label>Precio (€):</label>
        <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required>

        <label>Link CNFans:</label>
        <input type="url" name="link_cnfans" value="<?php echo $producto['link_cnfans']; ?>" required>

        <label>Imagen Actual:</label>
        <?php 
            // Ajustar ruta para visualización en admin
            $ruta_visual = strpos($producto['imagen_url'], 'http') === 0 ? $producto['imagen_url'] : '../' . $producto['imagen_url'];
        ?>
        <img src="<?php echo $ruta_visual; ?>" alt="Imagen actual" style="max-width: 100px; margin: 10px 0; display:block;">

        <label>Cambiar Imagen (Subir archivo):</label>
        <input type="file" name="imagen_archivo" accept="image/*">

        <label>O URL de imagen:</label>
        <input type="url" name="imagen_url" value="<?php echo $producto['imagen_url']; ?>">

        <label>Género:</label>
        <select name="genero">
            <option value="unisex" <?php if($producto['genero'] == 'unisex') echo 'selected'; ?>>Unisex</option>
            <option value="hombre" <?php if($producto['genero'] == 'hombre') echo 'selected'; ?>>Hombre</option>
            <option value="mujer" <?php if($producto['genero'] == 'mujer') echo 'selected'; ?>>Mujer</option>
        </select>

        <label>Categoría:</label>
        <select name="categoria_id">
            <?php while($c = mysqli_fetch_assoc($cats)): ?>
                <option value="<?php echo $c['id']; ?>" <?php if($producto['categoria_id'] == $c['id']) echo 'selected'; ?>>
                    <?php echo $c['nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" class="btn">Actualizar Producto</button>
    </form>
</main>

<style>
    .form-admin {
        background: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 600px;
        margin: auto;
    }
    .form-admin label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }
    .form-admin input, .form-admin select, .form-admin textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
</body>
</html>
