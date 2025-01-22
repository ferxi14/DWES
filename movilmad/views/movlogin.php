<?php
require_once '../db/movconfig.php';
$error = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = conexionDB();

    $query = "SELECT * FROM rclientes WHERE email = :email AND idcliente = :password";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        if(($usuario['fecha_baja'] != 'NULL') && $usuario['pendiente_pago'] == 0) {
            session_start();
            $_SESSION['usuario'] = [
                'idcliente' => $usuario['idcliente'],
                'email' => $usuario['email']
            ];
            header('Location: movwelcome.php');
            exit();
        } else {
            $error = 'Usario dado de baja o pediente de pago';
        }
    } else {
        $error = 'Login incorrecto';
    }
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page - MovilMad</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>
    <h1>MOVILMAD</h1>

    <div class="container ">
        <!--Aplicacion-->
        <div class="card border-success mb-3" style="max-width: 30rem;">
            <div class="card-header">Login Usuario</div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form id="" name="" action="" method="post" class="card-body">

                    <div class="form-group">
                        Email <input type="text" name="email" placeholder="email" class="form-control">
                    </div>
                    <div class="form-group">
                        Clave <input type="password" name="password" placeholder="password" class="form-control">
                    </div>

                    <input type="submit" name="submit" value="Login" class="btn btn-warning disabled">
                </form>

            </div>
        </div>
    </div>
    </div>

</body>

</html>