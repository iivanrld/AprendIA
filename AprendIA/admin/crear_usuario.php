<?php
require_once '../includes/session.php';
require_once '../config/database.php';
include '../includes/navbar.php';

Session::start();
// Verifica que el usuario esté logueado y sea admin
if (!Session::isLoggedIn() || Session::get('user_role') !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'alumno';

    // Validación básica
    if ($nombre === '' || $correo === '' || $password === '') {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Conectar a la base de datos
        $db = new Database();
        $conn = $db->getConnection();

        // Verificar si el correo ya está registrado
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $error = "El correo ya está registrado.";
        } else {
            // Encriptar la contraseña
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insertar nuevo usuario
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, password, rol) VALUES (:nombre, :correo, :password, :rol)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':rol', $rol);

            if ($stmt->execute()) {
                // Redireccionar a la lista de usuarios si se crea correctamente
                header("Location: usuarios.php");
                exit;
            } else {
                $error = "Error al crear el usuario. Intenta de nuevo.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario - AprendIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="../css/styles.css" rel="stylesheet">
</head>
    <body class="bg-light">
        <div class="container-fluid py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Crear Nuevo Usuario</h1>
                    <div>        
                        <a href="usuarios.php" class="btn btn-primary">
                            ← Volver a la lista</a>
                        <button type="submit" form="form-crear-usuario" class="btn btn-primary_simple btn-outline-success ms-2">
                            Crear Usuario</button>
                    </div>
            </div>


            <!-- Mostrar mensaje de error si existe -->
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div  class="tabla-usuarios formulario p-4">
                <form id="form-crear-usuario" class = "" method="POST" action="">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo:</label>
                        <input type="email" name="correo" id="correo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label for="rol" class="form-label">Rol:</label>
                        <select name="rol" id="rol" class="form-select" required>
                            <option value="alumno">Alumno</option>
                            <option value="docente">Docente</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
