<?php
session_start();
if (!isset($_SESSION['user'])) exit;

$file = $_POST['file'];
$owner = explode("/", $file)[1];

if ($_SESSION['user']['role'] === 'admin' || $_SESSION['user']['username'] === $owner) {
    unlink($file);
}
header("Location: gallery.php");
