<?php
session_start();

$host = "localhost";
$username = "root";
$password = "rootroot";
$dbname = "pedidos";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Inicializa contador de intentos fallidos en sesión
if (!isset($_SESSION['intentos_login'])) {
    $_SESSION['intentos_login'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerNumber = $_POST['customerNumber'];
    $password = $_POST['password'];

    var_dump($customerNumber, $password);
    var_dump($_SESSION['intentos_login']);

    try {
        // Consulta para obtener los datos del cliente
        $stmt = $conn->prepare("SELECT customerNumber, contactLastName FROM customers WHERE customerNumber = :customerNumber");
        $stmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            var_dump($user);

            $hashedPassword = password_hash($user['contactLastName'], PASSWORD_DEFAULT);
            var_dump($hashedPassword);

            // Verificar contraseña
            if (password_verify($password, $hashedPassword)) {
                // Restablecer intentos fallidos
                $_SESSION['intentos_login'] = 0;

                // Guardar datos en la sesión
                $_SESSION['customerNumber'] = $user['customerNumber'];

                // Redirigir al menú principal
                //header("Location: pe_inicio.php");
                exit();
            } else {
                $_SESSION['intentos_login']++; // Incrementar intentos fallidos si la verificación de la contraseña falla
                $error = "Fallo al iniciar sesión, contraseña incorrecta";
            }
        } else {
            $_SESSION['intentos_login']++; // Incrementar intentos fallidos si el usuario no está en la base de datos registrado
            $error = "Fallo al iniciar sesión, usuario no encontrado.";
        }

    } catch (PDOException $e) {
        $error = "Error al consultar en la base de datos" . $e->getMessage();
    }

    // Cerrar conexión si se alcanzan los 3 intentos fallidos
    if ($_SESSION['intentos_login'] == 3) {
        session_destroy();
        $conn = null;
        $error = "Has fallado el inicio de sesión 3 veces, conexión cerrada";
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Pedidos</title>
</head>

<body>
    <h1>Inicia sesión</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="customerNumber">Usuario:</label>
        <input type="number" id="customerNumber" name="customerNumber" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>

</html>