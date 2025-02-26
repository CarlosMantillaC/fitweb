<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

$host = "ep-damp-salad-a4z2z0dt-pooler.us-east-1.aws.neon.tech";
$dbname = "neondb";
$user = "neondb_owner";
$password = "npg_vaReLlbf9E7X";
$port = "5432";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require;connect_timeout=10";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener la URI y limpiarla
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $request_uri = rtrim($request_uri, '/');

    // Manejo de rutas
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $request_uri === '/usuarios') {
        $stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($usuarios);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $request_uri === '/usuarios') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, edad) VALUES (:nombre, :email, :edad)");
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':email' => $data['email'],
            ':edad' => $data['edad']
        ]);
        echo json_encode(['mensaje' => 'Usuario registrado exitosamente!']);
        exit();
    }

    // Si la ruta no existe
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}