<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = "users.json";
    if (!file_exists($file)) {
        file_put_contents($file, json_encode([], JSON_PRETTY_PRINT));
    }

    $users = json_decode(file_get_contents($file), true);
    foreach ($users as $user) {
        if ($user['username'] == $_POST['username']) {
            $error = "Usuario ya existe.";
            break;
        }
    }

    if (!isset($error)) {
        $newUser = [
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "role" => "user"
        ];
        $users[] = $newUser;
        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
        mkdir("uploads/" . $_POST['username']);
        header("Location: index.php?registered=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form method="post">
            <h2>Registro</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <input name="username" placeholder="Usuario" required>
            <input name="password" type="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
            <p><a href="index.php">¿Ya tienes cuenta? Inicia sesión</a></p>
        </form>
    </div>
</body>
</html>
