<?php
class Session {
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public static function destroy() {
        self::start();
        session_unset();
        session_destroy();
    }

    public static function isLoggedIn() {
        self::start();
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header("Location: ../Login.php");
            exit;
        }
    }

    // Función para obtener la ruta del dashboard según el rol
    public static function getDashboardPath($role) {
        switch($role) {
            case 'admin':
                return "admin/dashboard.php";
            case 'docente':
                return "docente/dashboard.php";
            case 'alumno':
                return "alumno/dashboard.php";
            default:
                return "Index.php";
        }
    }

    public static function redirectByRole($role) {
        // Determinar la ruta base absoluta
        // Obtener la ruta raíz de la aplicación
        $root_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        if (strpos($root_path, '/admin') !== false ||
            strpos($root_path, '/docente') !== false ||
            strpos($root_path, '/alumno') !== false) {
            // Si estamos en un subdirectorio, subir un nivel
            $root_path = dirname($root_path);
        }
        
        // Determinar la URL según el rol
        $target_url = "";
        switch($role) {
            case 'admin':
                $target_url = $root_path . "/admin/dashboard.php";
                break;
            case 'docente':
                $target_url = $root_path . "/docente/dashboard.php";
                break;
            case 'alumno':
                $target_url = $root_path . "/alumno/dashboard.php";
                break;
            default:
                $target_url = $root_path . "/Index.php";
        }
        
        // Redirigir
        header("Location: " . $target_url);
        exit;
    }
}
?>