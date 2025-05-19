<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];
$uploadDir = "uploads/" . $user['username'];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $msg = urlencode("Error al subir la imagen. Asegúrate de seleccionar un archivo válido.");
    header("Location: gallery.php?error=$msg");
    exit;
}

$filename = basename($_FILES['image']['name']);
$targetPath = $uploadDir . "/" . $filename;

// Validar tipo de archivo
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$fileType = mime_content_type($_FILES['image']['tmp_name']);

if (!in_array($fileType, $allowedTypes)) {
    $msg = urlencode("Solo se permiten archivos JPG, PNG o GIF.");
    header("Location: gallery.php?error=$msg");
    exit;
}

if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
    header("Location: gallery.php");
    exit;
} else {
    $msg = urlencode("Error al guardar el archivo.");
    header("Location: gallery.php?error=$msg");
    exit;
}
