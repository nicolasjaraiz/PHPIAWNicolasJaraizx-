<?php
include '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// PROCESAR FORMULARIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    
    if (empty($nombre)) {
        $error = "El nombre es obligatorio.";
    } else {
        // INSERT
        // Guardamos el nombre en la tabla categorias. El ID se crea solo (AUTO_INCREMENT)
        $sql = "INSERT INTO categorias (nombre) VALUES ('$nombre')";
        if (mysqli_query($conexion, $sql)) {
            header("Location: admin_categorias.php");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conexion);
        }
    }
}
?>

<main class="container">
    <h2>Nueva Categoría</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

    <form method="POST" action="" class="form-admin">
        <label>Nombre de la Categoría:</label>
        <input type="text" name="nombre" required>
        <button type="submit" class="btn">Guardar</button>
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
