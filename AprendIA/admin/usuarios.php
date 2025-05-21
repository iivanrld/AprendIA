<?php
require_once '../includes/session.php';
require_once '../config/database.php';

Session::start();
if (!Session::isLoggedIn() || Session::get('user_role') !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT id, nombre, correo, rol, fecha_registro FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - AprendIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include '../includes/navbar.php'; ?>
    <div class="container-fluid py-5">
       <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-4">Gestión de Usuarios</h1>
            <div>
                <a href="dashboard.php" class="btn btn-primary">
                    ← Volver al Dashboard</a>
                <a href="crear_usuario.php" class="btn btn-primary_simple btn-outline-success ms-2">
                    + Nuevo Usuario</a>
            </div>
       </div>

       <div class="table-wrapper">
            <table class="table tabla-usuarios table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['id'] ?></td>
                            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                            <td><?= htmlspecialchars($usuario['correo']) ?></td>
                            <td><?= ucfirst($usuario['rol']) ?></td>
                            <td><?= $usuario['fecha_registro'] ?></td>
                            <td>
                                <a href="editar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-primary_simple btn-outline-warning ms-2">Editar</a>
                                <a href="eliminar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-primary_simple btn-outline-danger ms-2" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
