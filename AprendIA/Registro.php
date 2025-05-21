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

$register_message = "";
$register_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = filter_input(INPUT_POST, 'fullname');
    $correo = filter_input(INPUT_POST, 'correo');
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password === $confirm_password) {
        // Comprobar si el correo ya existe
        $user->correo = $correo;
        if ($user->correoExists()) {
            $register_error = "El correo electrónico ya está registrado";
        } else {
            // Guardar usuario
            $user->nombre = $nombre;
            $user->correo = $correo;
            $user->password = $password;
            $user->rol = "alumno"; // Por defecto, rol de alumno
            
            if ($user->create()) {
                $register_message = "Registro completado correctamente. Ahora puedes iniciar sesión.";
            } else {
                $register_error = "Error al registrar el usuario. Inténtalo de nuevo.";
            }
        }
    } else {
        $register_error = "Las contraseñas no coinciden";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - AprendIA</title>
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
        <div class="card registration-card">
            <div class="card-body">
                <?php if (!empty($register_error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $register_error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($register_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $register_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="text-center mb-4">
                    <img src="img/logo.png" alt="AprendIA Logo" class="registration-logo">
                </div>
                <h2 class="text-center mb-4">Crear Cuenta</h2>
                <p class="text-center text-muted mb-4">Regístrate para comenzar tu aprendizaje personalizado</p>
                
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="registroForm">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" 
                            placeholder="Juan Pérez" required minlength="3">
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" 
                            placeholder="tu@ejemplo.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" 
                                required minlength="6">
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirmar contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm-password" 
                                name="confirm-password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Acepto los términos y condiciones y la política de privacidad
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Crear Cuenta
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <p>¿Ya tienes una cuenta? <a href="Login.php" class="login-link">Inicia sesión</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const passwordInput = this.previousElementSibling;
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });
        });

        // Validación de contraseñas en tiempo real
        const form = document.getElementById('registroForm');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm-password');

        form.addEventListener('submit', function(e) {
            if (password.value !== confirmPassword.value) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });

        confirmPassword.addEventListener('input', function() {
            if (password.value === confirmPassword.value) {
                confirmPassword.setCustomValidity('');
            } else {
                confirmPassword.setCustomValidity('Las contraseñas no coinciden');
            }
        });
    </script>
</body>
</html>