<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $users = json_decode(file_get_contents("users.json"), true);
    foreach ($users as $user) {
        if ($user['username'] == $_POST['username'] && $user['password'] == $_POST['password']) {
            $_SESSION['user'] = $user;
            header("Location: gallery.php");
            exit;
        }
    }
    $error = "Credenciales incorrectas.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Galería de Imágenes</h2>
    </header>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post">
            <input name="username" placeholder="Usuario" required>
            <input name="password" type="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
        <p><a href="register.php">¿No tienes cuenta? Regístrate</a></p>
    </div>
    <footer>
        &copy; <?= date('Y') ?> Tu Nombre o Proyecto
    </footer>
</body>
</html>
