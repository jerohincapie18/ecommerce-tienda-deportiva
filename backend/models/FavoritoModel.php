<?php
require_once("./config/main-config.php");

class FavoritoModel {
    private $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    // Agrega un producto a favoritos
    public function agregar($userId, $productoId) {
        // Usamos INSERT IGNORE por si el UNIQUE KEY frena el duplicado, no rompa el script
        $stmt = $this->db->prepare("INSERT IGNORE INTO favoritos (user_id, producto_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $productoId);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return $affected > 0; // Retorna true si se insertó, false si ya existía
    }

    // Elimina de favoritos (por si le vuelve a dar click para quitarlo)
    public function eliminar($userId, $productoId) {
        $stmt = $this->db->prepare("DELETE FROM favoritos WHERE user_id = ? AND producto_id = ?");
        $stmt->bind_param("ii", $userId, $productoId);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return $affected > 0;
    }

    // Obtiene todos los productos favoritos de un usuario específico
    public function obtenerPorUsuario($userId) {
        $stmt = $this->db->prepare("
            SELECT p.id, p.nombre, p.precio, p.imagen_url, p.categoria 
            FROM favoritos f
            INNER JOIN productos p ON f.producto_id = p.id
            WHERE f.user_id = ?
            ORDER BY f.fecha_agregado DESC
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    public function verificarFavorito($prodId, $userId)
    {
        $stmt = $this->db->prepare("SELECT id FROM favoritos WHERE user_id = ? AND producto_id = ?");
        $stmt->bind_param("ii", $userId, $prodId);
        $stmt->execute();
        $result = $stmt->get_result();
        $nroColumnas =$result->num_rows; //necesito saber el nro de columnas, porq el resultado solo me devolvera true siempre que se haga la consulta
        $stmt->close();
        return $nroColumnas;
    }
}