<?php
require_once '../includes/session.php';
require_once '../config/database.php';

Session::start();
if (!Session::isLoggedIn() || Session::get('user_role') !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: usuarios.php");
    exit;
}

$id = (int)$_GET['id'];

$db = new Database();
$conn = $db->getConnection();

// Eliminar usuario por ID
$stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

header("Location: usuarios.php");
exit;
