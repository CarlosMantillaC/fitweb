<?php
header("Access-Control-Allow-Origin: *"); // Permite CORS (en producción usa tu dominio)
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
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// ==============================================
// 2. PROCESAMIENTO DEL FORMULARIO
// ==============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $edad = intval($_POST['edad']);

    try {
        $stmt = $pdo->prepare("
            INSERT INTO usuarios (nombre, email, edad) 
            VALUES (:nombre, :email, :edad)
        ");

        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':edad' => $edad
        ]);

        $mensaje = "¡Usuario registrado exitosamente!";
    } catch (PDOException $e) {
        $error = "Error al insertar: " . $e->getMessage();
    }
}

// ==============================================
// 3. OBTENER REGISTROS EXISTENTES
// ==============================================
try {
    $stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener usuarios: " . $e->getMessage());
}
?>