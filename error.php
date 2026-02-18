<?php
include 'includes/header.php';
$mensaje = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : "Ha ocorregut un error desconegut.";
?>
<main class="container">
    <div style="text-align: center; margin-top: 50px;">
        <h2 style="color: red;">Error</h2>
        <p style="font-size: 1.2rem;"><?php echo $mensaje; ?></p>
        <a href="index.php" class="btn" style="margin-top: 20px; display: inline-block;">Tornar a l'Inici</a>
    </div>
</main>
</body>
</html>
