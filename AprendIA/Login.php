<?php
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'includes/session.php';

Session::start();

// Si ya está logueado, redirigir según rol
if (Session::isLoggedIn()) {
    Session::redirectByRole(Session::get('user_role'));
}

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if ($correo && $password) {
        $user->correo = $correo;
        
        // Verificar si el correo existe
        if ($user->correoExists()) {
            // Verificar contraseña
            if (password_verify($password, $user->password)) {
                // Guardar datos en sesión
                Session::set('user_id', $user->id);
                Session::set('user_name', $user->nombre);
                Session::set('user_correo', $user->correo);
                Session::set('user_role', $user->rol);
                
                // Redirigir según rol
                Session::redirectByRole($user->rol);
            } else {
                $login_error = "La contraseña es incorrecta";
            }
        } else {
            $login_error = "El correo electrónico no está registrado";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - AprendIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a href="Index.php" class="back-link">&larr; Volver al inicio</a>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center vh-75">
        <div class="card login-card">
            <div class="card-body">
                <?php if (!empty($login_error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $login_error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="text-center mb-4">
                    <img src="img/logo.png" alt="AprendIA Logo" class="login-logo">
                </div>
                <h2 class="text-center mb-4">Iniciar Sesión</h2>
                <p class="text-center text-muted mb-4">Ingresa tus credenciales para acceder a tu cuenta</p>
                
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="tu@ejemplo.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                        <a href="#" class="float-end forgot-password">¿Olvidaste tu contraseña?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>
                
                <div class="text-center mt-3">
                    <p>¿No tienes una cuenta? <a href="Registro.php" class="register-link">Regístrate</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>