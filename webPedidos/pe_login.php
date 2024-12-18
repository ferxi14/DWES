<?php

require_once 'pe_db.php';
$conn = conexionDB();

// Inicializa el contador de intentos fallidos con cookies
if (isset($_COOKIE['intentos_login'])) {
    $intentosLogin = (int)$_COOKIE['intentos_login'];
} else {
    $intentosLogin = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerNumber = $_POST['customerNumber'];
    $password = $_POST['password'];

    var_dump($customerNumber, $password);

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
                // Inicia la sesión y restablece intentos fallidos
                session_start();

                $_SESSION['customerNumber'] = $user['customerNumber'];

                setcookie('intentos_login', 0, time() - 3600); // Borra la cookie
                $intentosLogin = 0; // Actualiza el contador en el código
                header("Location: pe_inicio.php");
                exit();
            } else {
                // Contraseña incorrecta, incrementar intentos fallidos
                $intentosLogin++;
                $error = "Fallo al iniciar sesión";
            }
        } else {
            // Usuario no encontrado, incrementar intentos fallidos
            $intentosLogin++;
            $error = "Fallo al iniciar sesión";
        }

        // Actualiza la cookie con los nuevos intentos
        setcookie('intentos_login', $intentosLogin, time() + 3600);
        var_dump($intentosLogin);

    } catch (PDOException $e) {
        $error = "Error al consultar en la base de datos: " . $e->getMessage();
    }

    // Bloquea al usuario si supera los 3 intentos
    if ($intentosLogin >= 3) {
        $conn = null;
        $error = "Has fallado el inicio de sesión 3 veces, se ha cerrado la conexión";
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
