<?php
include '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// 1. OBTENER DATOS ACTUALES
// Necesitamos el ID de la categoría que vamos a editar
$id = $_GET['id'];
$res = mysqli_query($conexion, "SELECT * FROM categorias WHERE id=$id");
$cat = mysqli_fetch_assoc($res);

// Si no existe esa categoría, volvemos atrás
if (!$cat) {
    header("Location: admin_categorias.php");
    exit();
}

// 2. PROCESAR CAMBIOS
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    
    // UPDATE: Actualizamos el nombre de la fila que tenga este ID
    $sql = "UPDATE categorias SET nombre='$nombre' WHERE id=$id";
    if (mysqli_query($conexion, $sql)) {
        header("Location: admin_categorias.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conexion);
    }
}
?>

<main class="container">
    <h2>Editar Categoría</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

    <form method="POST" action="" class="form-admin">
        <label>Nombre de la Categoría:</label>
        <input type="text" name="nombre" value="<?php echo $cat['nombre']; ?>" required>
        <button type="submit" class="btn">Actualizar</button>
    </form>
</main>

<style>
    .form-admin {
        background: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 400px;
        margin: auto;
    }
    .form-admin label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }
    .form-admin input {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
</body>
</html>
