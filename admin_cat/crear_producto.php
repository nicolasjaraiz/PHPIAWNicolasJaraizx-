<?php
include '../config/db.php';
include '../includes/header.php';

// Solo administradores
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// OBTENER CATEGORÍAS
// Necesitamos la lista de categorías para ponerlas en el desplegable (select) del formulario
$cats = mysqli_query($conexion, "SELECT * FROM categorias");

// PROCESAR FORMULARIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Recogemos y limpiamos datos
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $desc = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $precio = $_POST['precio'];
    $link = mysqli_real_escape_string($conexion, $_POST['link_cnfans']);
    $genero = $_POST['genero'];
    $categoria_id = $_POST['categoria_id'];

    // Lógica para la IMAGEN
    $img = '';
    
    // Si han subido un archivo
    if (isset($_FILES['imagen_archivo']) && $_FILES['imagen_archivo']['error'] === 0) {
        $directorio = "../uploads/";
        
        // Crear carpeta si no existe
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombre_archivo = time() . "_" . basename($_FILES['imagen_archivo']['name']);
        $ruta_destino = $directorio . $nombre_archivo;

        if (move_uploaded_file($_FILES['imagen_archivo']['tmp_name'], $ruta_destino)) {
            // Guardamos la ruta relativa para usarla desde la raíz
            $img = "uploads/" . $nombre_archivo;
        } else {
            $error = "Error al subir la imagen.";
        }
    } 
    // Si no han subido archivo, miramos si han puesto URL
    elseif (!empty($_POST['imagen_url'])) {
        $img = mysqli_real_escape_string($conexion, $_POST['imagen_url']);
    }

    // 2. Validación básica
    if (empty($nombre) || empty($precio) || empty($link)) {
        $error = "Nombre, precio y link son obligatorios.";
    } else {
        // 3. Insertar en BD
        $sql = "INSERT INTO productos (nombre, descripcion, precio, link_cnfans, imagen_url, genero, categoria_id) 
                VALUES ('$nombre', '$desc', '$precio', '$link', '$img', '$genero', '$categoria_id')";
        
        if (mysqli_query($conexion, $sql)) {
            // Éxito: volvemos a la lista
            header("Location: admin_productos.php");
            exit();
        } else {
            $error = "Error al crear: " . mysqli_error($conexion);
        }
    }
}
?>

<main class="container">
    <h2>Nuevo Producto</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

    <!-- IMPORTANTE: enctype="multipart/form-data" es necesario para subir archivos -->
    <form method="POST" action="" class="form-admin" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Descripción:</label>
        <textarea name="descripcion"></textarea>

        <label>Precio (€):</label>
        <input type="number" step="0.01" name="precio" required>

        <label>Link CNFans:</label>
        <input type="url" name="link_cnfans" required>

        <!-- Opción 1: Subir imagen -->
        <label>Imagen del Producto (Subir archivo):</label>
        <input type="file" name="imagen_archivo" accept="image/*">

        <!-- Opción 2: URL Externa -->
        <label>O pegar URL de imagen:</label>
        <input type="url" name="imagen_url" placeholder="https://...">

        <label>Género:</label>
        <select name="genero">
            <option value="unisex">Unisex</option>
            <option value="hombre">Hombre</option>
            <option value="mujer">Mujer</option>
        </select>

        <label>Categoría:</label>
        <select name="categoria_id">
            <?php while($c = mysqli_fetch_assoc($cats)): ?>
                <option value="<?php echo $c['id']; ?>"><?php echo $c['nombre']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit" class="btn">Guardar Producto</button>
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
