<?php
require_once '../includes/session.php';
Session::start();

// Verificar inicio de sesión y rol
if (!Session::isLoggedIn() || Session::get('user_role') !== 'docente') {
    header("Location: ../Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de docente - AprendIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="../css/styles.css" rel="stylesheet">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 30px;
        }
        
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .docente-logo {
            height: 35px;
            margin-right: 10px;
        }
        
        .course-card {
            border-left: 4px solid var(--primary-color);
        }
        
        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #E9ECEF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #6C757D;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../img/logo.png" alt="AprendIA Logo" class="docente-logo">
                <span>Portal docente</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-house"></i> Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-book"></i> Mis Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-people"></i> alumnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-calendar-event"></i> Calendario</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="me-3">
                        <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars(Session::get('user_name')); ?>
                    </span>
                    <a href="../logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Panel de docente</h1>
            <div>
                <button class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nuevo Material
                </button>
                <button class="btn btn-outline-primary ms-2">
                    <i class="bi bi-envelope"></i> Mensajes
                </button>
            </div>
        </div>
        
        <!-- Resumen -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Bienvenido de nuevo, <?php echo htmlspecialchars(Session::get('user_name')); ?></h5>
                        <p class="card-text">Tienes <strong>3 cursos activos</strong> con un total de <strong>55 alumnos</strong>. 
                        Hay <strong>12 tareas</strong> pendientes de revisar y <strong>5 mensajes</strong> sin leer.</p>
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i> Recuerda que el próximo viernes es el plazo límite para la calificación del proyecto final de PHP Avanzado.
                        </div>
                    </div>
                </div>
                
                <h4 class="mb-3">Mis Cursos</h4>
                
                <div class="card course-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">PHP Avanzado</h5>
                            <span class="badge bg-success">Activo</span>
                        </div>
                        <p class="card-text text-muted">25 alumnos, 12 semanas</p>
                        <div class="progress mb-3" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">Progreso: 65% completado</small>
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-outline-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card course-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">JavaScript Moderno</h5>
                            <span class="badge bg-success">Activo</span>
                        </div>
                        <p class="card-text text-muted">18 alumnos, 10 semanas</p>
                        <div class="progress mb-3" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">Progreso: 30% completado</small>
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-outline-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card course-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Introducción a Python</h5>
                            <span class="badge bg-success">Activo</span>
                        </div>
                        <p class="card-text text-muted">12 alumnos, 8 semanas</p>
                        <div class="progress mb-3" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">Progreso: 80% completado</small>
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-outline-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Próximas Actividades</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0">Entrega Proyecto PHP</h6>
                                        <small class="text-muted">Viernes, 15:00h</small>
                                    </div>
                                    <span class="badge bg-danger">Prioritario</span>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0">Videoconferencia JavaScript</h6>
                                        <small class="text-muted">Jueves, 17:30h</small>
                                    </div>
                                    <span class="badge bg-warning text-dark">Programado</span>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0">Preparar examen Python</h6>
                                        <small class="text-muted">Lunes, 10:00h</small>
                                    </div>
                                    <span class="badge bg-info">Pendiente</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">alumnos Destacados</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <div class="student-avatar me-3">MA</div>
                                    <div>
                                        <h6 class="mb-0">María Álvarez</h6>
                                        <small class="text-muted">PHP Avanzado - 98% completado</small>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <div class="student-avatar me-3">JG</div>
                                    <div>
                                        <h6 class="mb-0">Juan García</h6>
                                        <small class="text-muted">JavaScript - 92% completado</small>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <div class="student-avatar me-3">LR</div>
                                    <div>
                                        <h6 class="mb-0">Laura Rodríguez</h6>
                                        <small class="text-muted">Python - 95% completado</small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-sm btn-outline-primary">Ver todos los alumnos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>