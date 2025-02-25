<?php
// ==============================================
// 1. CONEXIÓN A LA BASE DE DATOS (NEON.TECH)
// ==============================================

$host = getenv('postgresql://neondb_owner:npg_v2EtfO0nqIop@ep-rapid-forest-a4udz660-pooler.us-east-1.aws.neon.tech/neondb?sslmode=require');
$dbname = getenv('neondb');
$user = getenv('neondb_owner');
$password = getenv('npg_v2EtfO0nqIop');
$port = getenv('5432');

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Usuarios</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 20px; }
        .form-container { background: #f4f4f4; padding: 20px; border-radius: 8px; }
        .success { color: green; }
        .error { color: red; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Registro de Usuarios</h2>
        
        <?php if (isset($mensaje)): ?>
            <p class="success"><?= $mensaje ?></p>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST">
            <div>
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            
            <div>
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            
            <div>
                <label>Edad:</label>
                <input type="number" name="edad" min="1" required>
            </div>
            
            <button type="submit">Registrar</button>
        </form>
    </div>

    <h3>Usuarios Registrados</h3>
    <?php if (!empty($usuarios)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Edad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td><?= $usuario['edad'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay usuarios registrados.</p>
    <?php endif; ?>
</body>
</html>