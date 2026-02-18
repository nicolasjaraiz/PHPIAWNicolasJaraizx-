<?php
// 1. INICIAR SESIÓN (Necesario para poder destruirla)
// Aunque suene raro, debes "unirte" a la sesión actual para poder borrarla.
session_start();

// 2. ELIMINAR VARIABLES
// Borra todos los valores de $_SESSION (id, email, rol, etc.)
session_unset();

// 3. DESTRUIR LA SESIÓN
// Elimina la sesión completamente del servidor. el usuario "olvida" estar logueado.
session_destroy();

// 4. REDIRECCIÓN
// Enviamos al usuario de vuelta a la portada.
header("Location: index.html");
exit();
?>