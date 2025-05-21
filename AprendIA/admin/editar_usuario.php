<?php
require_once '../includes/session.php';
require_once '../config/database.php';
include '../includes/navbar.php';

Session::start();
// Solo admins pueden acceder
if (!Session::isLoggedIn() || Session::get('user_role') !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

// Verificar que se pase un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: usuarios.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$id = (int)$_GET['id'];
$error = '';

// Obtener datos actuales del usuario
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: usuarios.php");
    exit;
}

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $rol = $_POST['rol'] ?? 'alumno';

    if ($nombre === '' || $correo === '') {
        $error = "Nombre y correo son obligatorios.";
    } else {
        // Verificar si el nuevo correo ya está en uso (por otro usuario)
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = :correo AND id != :id");
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $error = "Ese correo ya está en uso por otro usuario.";
        } else {
            // Actualizar datos
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = :nombre, correo = :correo, rol = :rol WHERE id = :id");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                header("Location: usuarios.php");
                exit;
            } else {
                $error = "Error al actualizar el usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - AprendIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="../css/styles.css" rel="stylesheet">

</head>
    <body class="bg-light">
        <div class="container-fluid py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Editar Usuario</h1>
                    <div>
                        <a href="usuarios.php" class="btn btn-primary">
                            ← Volver</a>
                        <button type="submit" form="form-editar-usuario" class="btn btn-primary_simple btn-outline-success ms-2">
                            Guardar Cambios</button>
                    </div>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="tabla-usuarios formulario p-4">
                <form id="form-editar-usuario" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre:</label>
                        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" class="form-control" required>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Correo:</label>
                        <input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" class="form-control" required>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Rol:</label>
                        <select name="rol" class="form-select" required>
                            <option value="alumno" <?= $usuario['rol'] === 'alumno' ? 'selected' : '' ?>>Alumno</option>
                            <option value="docente" <?= $usuario['rol'] === 'docente' ? 'selected' : '' ?>>Docente</option>
                            <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                        </select>
                    </div>
    
                </form>
            </div>
        </div>
    </body>
</html>
