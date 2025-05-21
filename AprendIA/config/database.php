<?php
class Database {
    // Datos de conexión (ajustá si usás otro entorno)
    private string $host = "localhost";
    private string $db_name = "aprendia";
    private string $username = "root";
    private string $password = "";
    private ?PDO $conn = null; // Conexión puede ser null

    /**
     * Establece y retorna la conexión PDO a la base de datos.
     *
     * @return PDO|null Retorna una instancia de PDO si la conexión es exitosa, null si falla.
     */
    public function getConnection(): ?PDO {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            // Activar errores como excepciones
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // En producción, se recomienda **no mostrar** mensajes de error directamente
            error_log("Error de conexión: " . $e->getMessage());
            // Opcional: mostrar mensaje genérico o redirigir
            echo "No se pudo conectar a la base de datos.";
        }

        return $this->conn;
    }
}
?>
