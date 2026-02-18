<?php
// Incluimos la conexión a la BD para poder buscar usuarios
include 'config/db.php';
// Incluimos el header para tener el diseño y la sesión iniciada
include 'includes/header.php';

$error = "";

// VERIFICAMOS SI EL FORMULARIO SE HA ENVIADO
// $_SERVER["REQUEST_METHOD"] nos dice si la página se cargó normal (GET) o si enviaron datos (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // RECOGIDA DE DATOS Y LIMPIEZA
    // mysqli_real_escape_string: IMPORTANTE para seguridad. Limpia caracteres especiales
    // para evitar que alguien hackee la web (Inyección SQL).
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password']; // La contraseña cruda, tal cual la escribió el usuario

    // 1. PREPARAMOS LA CONSULTA SQL
    // Buscamos si existe alguien con ese email
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    
    // Ejecutamos la consulta en la base de datos
    $resultado = mysqli_query($conexion, $sql);

    // 2. COMPROBAMOS SI SE ENCONTRÓ ALGO
    // mysqli_fetch_assoc convierte el resultado en un array asociativo (como una lista)
    if ($usuario = mysqli_fetch_assoc($resultado)) {
        
        // 3. VERIFICAMOS LA CONTRASEÑA
        // password_verify compara la contraseña escrita con el hash encriptado de la BD
        // NUNCA comparar contraseñas directas (texto plano) por seguridad.
        if (password_verify($password, $usuario['password'])) {
            
            // 4. INICIO DE SESIÓN EXITOSO
            // Guardamos datos en $_SESSION. Estas variables "viajan" entre páginas.
            // Mientras el navegador esté abierto, recordará quién es el usuario.
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['rol'] = $usuario['rol']; // Guardamos si es admin o usuario

            // Redirigimos a la página principal
            header("Location: index.php");
            exit(); // Siempre usar exit() después de un header Location
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El usuario no existe.";
    }
}
?>

<main class="container">
    <h2>Iniciar Sesión</h2>
    <?php if (isset($_GET['registro'])) echo "<p style='color:green'>¡Registro completado! Ya puedes entrar a comprar cositas.</p>"; ?>
    <?php if ($error) echo "<p style='color:red'>$error</p>"; ?>

    <form method="POST" action="login.php">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Entrar</button>
    </form>
</main>
</body>
</html>