<?php
include 'config/db.php';
include 'includes/header.php';

$mensaje = "";

// Solo ejecutamos este código si el usuario pulsó el botón "Registrarse"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. SEGURIDAD: LIMPIEZA DE DATOS
    // Usamos real_escape_string para evitar que rompan la consulta SQL
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    
    // Las contraseñas no necesitan escape aquí porque no van directo a la SQL (se encriptan después)
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $rol = 'usuario'; // Por defecto, todos son usuarios normales

    // 2. VALIDACIONES DE FORMULARIO
    // Comprobamos que no haya campos vacíos
    if (empty($email) || empty($pass1) || empty($pass2)) {
        $mensaje = "Todos los campos son obligatorios.";
    
    // filter_var valida que el texto sea realmente un email (tiene @, punto, etc.)
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El formato del email no es válido.";
        
    // Comprobamos que las dos contraseñas sean idénticas
    } elseif ($pass1 !== $pass2) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        
        // 3. VERIFICAR DUPLICADOS
        // Consultamos la BD para ver si el email ya existe
        $sql_check = "SELECT id FROM usuarios WHERE email = '$email'";
        $resultado_check = mysqli_query($conexion, $sql_check);

        // mysqli_num_rows nos dice cuántas filas ha devuelto la consulta
        if (mysqli_num_rows($resultado_check) > 0) {
            $mensaje = "Este email ya está registrado.";
        } else {
            
            // 4. ENCRIPTACIÓN (HASHING)
            // password_hash convierte "hola123" en algo ilegible como "$2y$10$..."
            // Esto es OBLIGATORIO por ley y buenas prácticas.
            $password_encriptada = password_hash($pass1, PASSWORD_DEFAULT);

            // 5. INSERTAR EN LA BASE DE DATOS
            // Creamos la sentencia SQL para guardar el nuevo usuario
            $sql_insert = "INSERT INTO usuarios (email, password, rol) VALUES ('$email', '$password_encriptada', '$rol')";
            
            // Ejecutamos la inserción
            if (mysqli_query($conexion, $sql_insert)) {
                // Si todo va bien, redirigimos al login con un mensaje de éxito
                header("Location: login.php?registro=exito");
                exit();
            } else {
                // Si falla SQL, mostramos el error técnico
                $mensaje = "Error al registrar: " . mysqli_error($conexion);
            }
        }
    }
}
?>

<main class="container">
    <h2>Crear Cuenta</h2>
    <?php if ($mensaje): ?>
        <p style="color: red;"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form method="POST" action="registro.php">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="pass1" required>
        </div>
        <div class="form-group">
            <label>Repite la Contraseña:</label>
            <input type="password" name="pass2" required>
        </div>
        <button type="submit" class="btn">Registrarse</button>
    </form>
</main>
</body>
</html>