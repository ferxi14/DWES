<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form name='juegodados' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

        <div class="card border-success mb-3" style="max-width: 30rem;">
            <div class="card-header">
                <b>JUEGO DADOS</b>
            </div>
            <div class="card-body">
                <b>Nombre:</b>
                <input type="text" name="nombre" value="" size="25">
                <br><br>
                <b>Apellidos:</b>
                <input type="text" name="apellido" value="" size="25">
                <br><br>
                <b>Email:</b>
                <input type="text" name="email" value="" size="25">
                <br><br>
                <b>Pulsa para registrarte</b>
                <br>
                <input type="submit" value="Registrar" name="registrar" class="btn btn-warning disabled">
                <br><br>
            </div>
        </div>






    </form>
</body>

</html>