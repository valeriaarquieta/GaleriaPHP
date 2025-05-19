<?php
session_start();
if (!isset($_SESSION['user'])) exit("Acceso denegado.");
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Galería de Imágenes</h2>
        <?php if (isset($_SESSION['user'])): ?>
        <a class="logout" href="logout.php">Cerrar sesión</a>
        <?php endif; ?>
    </header>
    <div class="container">
        <h2>Hola, <?= htmlspecialchars($user['username']) ?></h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image" required>
            <button type="submit">Subir Imagen</button>
        </form>

<?php
function mostrarImagenes($carpeta) {
    echo "<div class='gallery'>";
    foreach (glob("$carpeta/*") as $archivo) {
        echo "<div class='image-card'>";
        echo "<img src='$archivo'><br>";
        echo "<form method='post' action='delete.php'>";
        echo "<input type='hidden' name='file' value='$archivo'>";
        echo "<button type='submit'>Eliminar</button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";
}

if ($user['role'] == 'admin') {
    foreach (glob("uploads/*") as $carpeta) {
        echo "<h3>" . basename($carpeta) . "</h3>";
        mostrarImagenes($carpeta);
    }
} else {
    $userFolder = "uploads/" . $user['username'];
    mostrarImagenes($userFolder);
}
?>
    </div>
    <footer>
        <p>Lenguajes de programación Back End</p>
        <p>UDG</p>
        &copy; <?= date('Y') ?> Valeria Arquieta
    </footer>
    <?php if (isset($_GET['error'])): ?>
    <script>
        alert("<?= htmlspecialchars($_GET['error']) ?>");
    </script>
    <?php endif; ?>
</body>
</html>
