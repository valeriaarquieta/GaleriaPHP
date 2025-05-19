<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $users = json_decode(file_get_contents("users.json"), true);
    foreach ($users as $user) {
        if ($user['username'] == $_POST['username']) {
            exit("Usuario ya existe.");
        }
    }

    $newUser = [
        "username" => $_POST['username'],
        "password" => $_POST['password'],
        "role" => "user"
    ];
    $users[] = $newUser;
    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));

    mkdir("uploads/" . $_POST['username']);
    echo "Usuario registrado. <a href='index.php'>Inicia sesión</a>";
}
?>
<form method="post">
    <h2>Registro</h2>
    <input name="username" required>
    <input name="password" type="password" required>
    <button type="submit">Registrarse</button>
</form>
