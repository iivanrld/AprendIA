<?php
require_once '../includes/session.php';
Session::start();

// Verificar inicio de sesión y rol
if (!Session::isLoggedIn() || Session::get('user_role') !== 'alumno') {
    header("Location: ../Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de alumno - AprendIA</title>
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
        
        .student-logo {
            height: 35px;
            margin-right: 10px;
        }
        
        .course-banner {
            height: 120px;
            object-fit: cover;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        
        .course-progress {
            height: 8px;
            background-color: #E9ECEF;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .course-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color) 0%, #FF6090 100%);
        }
        
        .achievement-badge {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 2rem;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../img/logo.png" alt="AprendIA Logo" class="student-logo">
                <span>AprendIA Campus</span>
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
                        <a class="nav-link" href="#"><i class="bi bi-search"></i> Explorar Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-calendar-event"></i> Eventos</a>
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
            <h1>¡Bienvenido, <?php echo htmlspecialchars(Session::get('user_name')); ?>!</h1>
            <div>
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-book"></i> Continuar aprendiendo
                </a>
            </div>
        </div>
        
        <!-- Progreso general -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Tu progreso de aprendizaje</h5>
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <p class="mb-1">Progreso general en cursos</p>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">65% completado</small>
                            <small class="text-muted">3 de 5 cursos en progreso</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="d-inline-block p-3 rounded-circle" style="background-color: #f8f9fa;">
                            <h2 class="mb-0">75</h2>
                            <small class="text-muted">puntos esta semana</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cursos en progreso -->
        <h4 class="mb-3">Tus cursos en progreso</h4>
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <img src="https://via.placeholder.com/400x120/E91E63/FFFFFF?text=PHP" class="course-banner" alt="PHP">
                    <div class="card-body">
                        <h5 class="card-title">PHP Avanzado</h5>
                        <p class="card-text text-muted">Domina las técnicas avanzadas de PHP y mejora tus habilidades de desarrollo backend.</p>
                        <div class="d-flex justify-content-between mb-2">
                            <small>Progreso: 75%</small>
                            <small>12/16 lecciones</small>
                        </div>
                        <div class="course-progress mb-3">
                            <div class="course-progress-bar" style="width: 75%;"></div>
                        </div>
                        <a href="#" class="btn btn-primary w-100">Continuar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <img src="https://via.placeholder.com/400x120/FFC107/FFFFFF?text=JavaScript" class="course-banner" alt="JavaScript">
                    <div class="card-body">
                        <h5 class="card-title">JavaScript Moderno</h5>
                        <p class="card-text text-muted">Aprende las características modernas de JavaScript y mejora tus aplicaciones web.</p>
                        <div class="d-flex justify-content-between mb-2">
                            <small>Progreso: 45%</small>
                            <small>9/20 lecciones</small>
                        </div>
                        <div class="course-progress mb-3">
                            <div class="course-progress-bar" style="width: 45%;"></div>
                        </div>
                        <a href="#" class="btn btn-primary w-100">Continuar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <img src="https://via.placeholder.com/400x120/3F51B5/FFFFFF?text=Python" class="course-banner" alt="Python">
                    <div class="card-body">
                        <h5 class="card-title">Python para IA</h5>
                        <p class="card-text text-muted">Aprende conceptos básicos de Inteligencia Artificial y Machine Learning con Python.</p>
                        <div class="d-flex justify-content-between mb-2">
                            <small>Progreso: 30%</small>
                            <small>6/20 lecciones</small>
                        </div>
                        <div class="course-progress mb-3">
                            <div class="course-progress-bar" style="width: 30%;"></div>
                        </div>
                        <a href="#" class="btn btn-primary w-100">Continuar</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sección inferior -->
        <div class="row">
            <div class="col-md-8">
                <h4 class="mb-3">Actividades pendientes</h4>
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Proyecto Final PHP</h6>
                                        <p class="text-muted mb-0">PHP Avanzado • Entrega: en 3 días</p>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Ver detalles</a>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Quiz de JavaScript</h6>
                                        <p class="text-muted mb-0">JavaScript Moderno • Entrega: en 5 días</p>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Iniciar quiz</a>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Ejercicio práctico de Python</h6>
                                        <p class="text-muted mb-0">Python para IA • Entrega: en 7 días</p>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Ver detalles</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="mb-3">Logros recientes</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4 mb-3">
                                <div class="achievement-badge">
                                    <i class="bi bi-lightning-charge"></i>
                                </div>
                                <small>Racha de 7 días</small>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="achievement-badge">
                                    <i class="bi bi-trophy"></i>
                                </div>
                                <small>Primer proyecto</small>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="achievement-badge">
                                    <i class="bi bi-star"></i>
                                </div>
                                <small>5 ejercicios</small>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-sm w-100 mt-2">Ver todos los logros</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>