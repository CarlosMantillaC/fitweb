<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Conexión a Neon (PostgreSQL)
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener todos los usuarios (GET)
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $conn->query("SELECT * FROM usuarios ORDER BY fecha_registro DESC");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'data' => $usuarios
        ]);
    }

    // Crear un nuevo usuario (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        $nombre = $data['nombre'];
        $email = $data['email'];
        $edad = $data['edad'];

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, edad) VALUES (:nombre, :email, :edad)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':edad', $edad);
        $stmt->execute();

        echo json_encode([
            'status' => 'success',
            'message' => 'Usuario creado correctamente'
        ]);
    }

} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>