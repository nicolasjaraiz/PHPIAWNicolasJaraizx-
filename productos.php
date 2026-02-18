<?php
include 'config/db.php';
include 'includes/header.php';

// 1. GESTIÓN DE BÚSQUEDA Y ORDENACIÓN
// isset() comprueba si una variable existe o es nula.
// $_GET recoge los datos de la URL (ej: ?buscar=zapatillas)

// Si hay algo en 'buscar', lo limpiamos por seguridad. Si no, cadena vacía.
$busqueda = isset($_GET['buscar']) ? mysqli_real_escape_string($conexion, $_GET['buscar']) : '';

// Si hay algo en 'orden', lo usamos. Si no, ordenamos por 'nombre' por defecto.
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'nombre';

// 2. CONSTRUCCIÓN DE LA CONSULTA SQL
// SELECT p.*: Selecciona todo de la tabla productos (alias p)
// c.nombre AS categoria_nombre: Selecciona el nombre de la categoria y le pone un "apodo"
// JOIN: Une la tabla productos con categorias usando el ID para saber el nombre de la categoría
// WHERE LIKE: Busca productos cuyo nombre contenga ($busqueda)
// ORDER BY: Ordena los resultados según la variable $orden
$sql = "SELECT p.*, c.nombre AS categoria_nombre 
        FROM productos p 
        JOIN categorias c ON p.categoria_id = c.id 
        WHERE p.nombre LIKE '%$busqueda%' 
        ORDER BY $orden ASC";

// Ejecutamos la consulta
$resultado = mysqli_query($conexion, $sql);
?>

<main class="container">
    <h2>Catálogo CNFans</h2>

    <form method="GET" action="productos.php" style="margin-bottom: 20px; display: flex; gap: 10px;">
        <input type="text" name="buscar" placeholder="Buscar producto..." value="<?php echo htmlspecialchars($busqueda); ?>">
        
        <select name="orden">
            <option value="nombre" <?php if($orden == 'nombre') echo 'selected'; ?>>Nombre (A-Z)</option>
            <option value="precio" <?php if($orden == 'precio') echo 'selected'; ?>>Precio (Más bajo)</option>
        </select>
        
        <button type="submit" class="btn">Aplicar</button>
    </form>

    <div class="grid-productos">
        <?php 
        // 3. MOSTRAR RESULTADOS
        // while recorre todos los resultados de la base de datos uno por uno.
        // mysqli_fetch_assoc coge la siguiente fila y la convierte en array.
        // El bucle se detiene cuando ya no hay más productos.
        while ($prod = mysqli_fetch_assoc($resultado)): 
        ?>
            <div class="card">
                <!-- SEGURIDAD: Evitar src="" vacío porque algunos navegadores recargan la página -->
                <?php 
                $img_src = !empty($prod['imagen_url']) ? $prod['imagen_url'] : 'https://via.placeholder.com/300?text=No+Image';
                ?>
                <img src="<?php echo $img_src; ?>" alt="<?php echo $prod['nombre']; ?>" onerror="this.src='https://via.placeholder.com/300?text=No+Image'">
                
                <div class="card-content">
                    <div class="card-title"><?php echo $prod['nombre']; ?></div>
                    <p>Categoría: <?php echo $prod['categoria_nombre']; ?></p>
                    <p>Género: <?php echo $prod['genero']; ?></p>
                    <p><strong>Precio: <?php echo $prod['precio']; ?>€</strong></p>
                    
                    <a href="<?php echo $prod['link_cnfans']; ?>" target="_blank" class="btn" style="background-color: var(--verde-claro);">Ver en CNFans</a>
                    
                    <!-- Solo mostramos el botón de favoritos si el usuario está logueado -->
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="favoritos_accion.php?id=<?php echo $prod['id']; ?>" class="btn">Añadir a Favoritos</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>
</body>
</html>