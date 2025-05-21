<?php
require_once 'includes/session.php';
Session::start();

// Función para obtener la URL correcta del dashboard según el rol
function getDashboardUrl($role) {
    switch($role) {
        case 'admin':
            return "admin/dashboard.php";
        case 'docente':
            return "docente/dashboard.php";
        case 'alumno':
            return "alumno/dashboard.php";
        default:
            return "#";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AprendIA - Formación en Programación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        .logo {
            max-width: 200px;
            max-height: 150px;
            object-fit: contain;
            transition: all 0.3s ease;
            animation: logoFadeIn 0.7s ease-out, logoPulse 3s infinite 1s;
        }
        
        .btn-custom {
            border-radius: 25px;
            padding: 12px 30px;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-dashboard {
            background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%);
            border: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="AprendIA Logo" height="30">
            </a>
            <div class="navbar-nav ms-auto">
                <a href="#" class="nav-link">Acerca de</a>
                <a href="#" class="nav-link">Contacto</a>
                <?php if (!Session::isLoggedIn()): ?>
                    <a href="Login.php" class="nav-link">Iniciar Sesión</a>
                <?php else: ?>
                    <a href="logout.php" class="nav-link">Cerrar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <div class="logo-container mb-4">
            <img src="img/logo.png" alt="AprendIA Logo" class="logo">
        </div>
        
        <h1 class="mb-3">Bienvenido a AprendIA</h1>
        
        <?php if (Session::isLoggedIn()): ?>
            <p class="text-muted mb-4">Hola, <?php echo htmlspecialchars(Session::get('user_name')); ?>. ¿Qué deseas hacer hoy?</p>
            
            <div class="d-grid gap-2 col-md-6 mx-auto">
                <a href="<?php echo getDashboardUrl(Session::get('user_role')); ?>" class="btn btn-warning btn-lg btn-custom btn-dashboard">Ir a mi Dashboard</a>
                <a href="logout.php" class="btn btn-danger btn-lg btn-custom">Cerrar Sesión</a>
            </div>
        <?php else: ?>
            <p class="text-muted mb-4">Formación personalizada en lenguajes de programación</p>
            
            <div class="d-grid gap-2 col-md-7 mx-auto">
                <a href="Login.php" class="btn btn-primary btn-lg btn-custom">Iniciar Sesión</a>
                <a href="Registro.php" class="btn btn-outline-secondary btn-lg btn-custom">Crear Cuenta</a>
            </div>
            
            <p class="mt-4 text-muted">Aprende Java, PHP, Python y más con contenido adaptado a tu ritmo y necesidades</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>