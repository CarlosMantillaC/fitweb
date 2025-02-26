<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Configuración de la base de datos Neon (PostgreSQL)
$host = getenv('ep-damp-salad-a4z2z0dt-pooler.us-east-1.aws.neon.tech');
$dbname = getenv('neondb');
$user = getenv('neondb_owner');
$password = getenv('npg_vaReLlbf9E7X');

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Ejemplo de endpoint
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $conn->query("SELECT NOW() AS current_time");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'status' => 'success',
            'data' => $result,
            'message' => 'Conexión exitosa a Neon PostgreSQL'
        ]);
    }
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de conexión: ' . $e->getMessage()
    ]);
}
?>


