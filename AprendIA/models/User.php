<?php
require_once 'config/database.php';

class User {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $correo;
    public $password;
    public $rol;
    public $fecha_registro;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET nombre = :nombre, 
                    correo = :correo, 
                    password = :password, 
                    rol = :rol,
                    fecha_registro = NOW()";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->rol = htmlspecialchars(strip_tags($this->rol));
        
        // Bind values
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        
        // Hash the password
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $password_hash);
        
        // Por defecto, rol de alumno
        $role = $this->rol ?? "alumno";
        $stmt->bindParam(":rol", $role);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function correoExists() {
        $query = "SELECT id, nombre, correo, password, rol FROM " . $this->table_name . " WHERE correo = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $stmt->bindParam(1, $this->correo);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->password = $row['password'];
            $this->rol = $row['rol'];
            return true;
        }
        return false;
    }
}
?>