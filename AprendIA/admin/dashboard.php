<?php
require_once '../includes/session.php';
include '../includes/navbar.php';
Session::start();

// Verificar inicio de sesión y rol
if (!Session::isLoggedIn() || Session::get('user_role') !== 'admin') {
    header("Location: ../Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - AprendIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="../css/styles.css" rel="stylesheet">

</head>
<body>
    <div class="dashboard-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Panel de Administración</h1>
            <div>
                <button class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nuevo Curso
                </button>
                <a class="btn btn-outline-primary ms-2" href="crear_usuario.php">
                    <i class="bi bi-person-plus"></i> Nuevo Usuario
                </a>
            </div>
        </div>
        
        <!-- Tarjetas de estadísticas -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Usuarios Totales</h6>
                            <h2 class="mb-0">248</h2>
                        </div>
                        <i class="bi bi-people stats-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Cursos Activos</h6>
                            <h2 class="mb-0">12</h2>
                        </div>
                        <i class="bi bi-book stats-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">docentees</h6>
                            <h2 class="mb-0">8</h2>
                        </div>
                        <i class="bi bi-mortarboard stats-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Ingresos</h6>
                            <h2 class="mb-0">€2,450</h2>
                        </div>
                        <i class="bi bi-graph-up stats-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tarjetas de gestión -->
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-people"></i> Gestión de Usuarios</h5>
                        <p class="card-text">Administra usuarios, roles y permisos. Agrega, edita o desactiva cuentas.</p>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                alumnos
                                <span class="badge bg-primary rounded-pill">230</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                docentees
                                <span class="badge bg-primary rounded-pill">8</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Administradores
                                <span class="badge bg-primary rounded-pill">2</span>
                            </li>
                        </ul>
                        <a href="usuarios.php" class="btn btn-primary">Ir a Usuarios</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-book"></i> Gestión de Cursos</h5>
                        <p class="card-text">Crea, edita y elimina cursos. Asigna docentees y gestiona el contenido.</p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>PHP Avanzado</span>
                                <small>14 alumnos</small>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>JavaScript Moderno</span>
                                <small>23 alumnos</small>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Python para IA</span>
                                <small>18 alumnos</small>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary">Ir a Cursos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-graph-up"></i> Reportes</h5>
                        <p class="card-text">Analiza el rendimiento de la plataforma con estadísticas y reportes detallados.</p>
                        <div class="text-center my-3">
                            <div style="height: 120px; background-color: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <span class="text-muted">Gráfica de usuarios activos</span>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary">Ver Reportes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>