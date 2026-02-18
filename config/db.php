<?php
/**
 * ARCHIVO DE CONFIGURACIÓN DE LA BASE DE DADES
 * -------------------------------------------
 * Este archivo se encarga de conectar PHP con MySQL.
 * Se incluye en todas las páginas que necesiten acceder a los datos.
 */

// Definición de variables con los datos de conexión
// localhost: significa que la base de datos está en el mismo ordenador
$servidor = "localhost";
$usuario  = "root";      // Usuario administrador por defecto en XAMPP
$password = "";          // En XAMPP, la contraseña de root suele estar vacía
$base_datos = "cnfans_db"; // El nombre exacto de la base de datos que creamos en SQL

// 1. INTENTO DE CONEXIÓN
// Utilizamos la función mysqli_connect() que es la forma moderna de conectar en PHP
$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos);

// 2. VERIFICACIÓN DE ERRRORES
// Si la conexión falla, $conexion será falso (false).
if (!$conexion) {
    // die() detiene la ejecución del script inmediatamente y muestra el mensaje.
    // mysqli_connect_error() nos dice la razón técnica del error.
    die("Error crítico: No se ha podido conectar a la base de datos. Detalles: " . mysqli_connect_error());
}

// 3. CONFIGURACIÓN DE CARACTERES
// Esto es vital para que las tildes, ñ y caracteres especiales se vean bien.
mysqli_set_charset($conexion, "utf8");

?>