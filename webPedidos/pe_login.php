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

/*// Inicializar contador de intentos fallidos en sesión
if (!isset($_SESSION['intentos_login'])) {
    $_SESSION['intetos_login'] = 0;
}*/

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['intetos_login'])) {
    header("Location: pe_inicio.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerNumber = $_POST['customerNumber'];
    $password = $_POST['password'];

    var_dump("Datos recibidos: ", $customerNumber, $password);

    try {
        // Consulta para obtener los datos del cliente
        $stmt = $conn->prepare("SELECT customerNumber, contactLastName FROM customers WHERE customerNumber = :customerNumber");
        $stmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
        $stmt->execute();

        var_dump("Número de filas encontradas: ", $stmt->rowCount());
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            var_dump("Datos del usuario: ", $user);

            $hashedPassword = password_hash($user['contactLastName'], PASSWORD_DEFAULT);

            // Verificar contraseña
            if (password_verify($password, $hashedPassword)) {
                // Restablecer intentos fallidos
                $_SESSION['login_attempts'] = 0;

                // Guardar datos en la sesión
                $_SESSION['customerNumber'] = $user['customerNumber'];

                // Redirigir al menú principal
                header("Location: pe_inicio.php");
                exit;
            } else {
                $_SESSION['login_attempts']++; // Incrementar intentos fallidos
                $error = "Contraseña incorrecta.";
            }
        } else {
            $_SESSION['login_attempts']++; // Incrementar intentos fallidos
            $error = "Usuario no encontrado.";
        }

    } catch (PDOException $e) {
        $error = "Error al consultar en la base de datos" . $e->getMessage();
    }

    // Cerrar conexión si se alcanzan los 3 intentos fallidos
    if ($_SESSION['login_attempts'] >= 3) {
        $conn = null; // Cerrar conexión
        $error = "Has fallado el inicio de sesión 3 veces. Conexión cerrada.";
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
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