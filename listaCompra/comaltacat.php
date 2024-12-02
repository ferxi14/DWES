<?php
$host = "localhost";
$username = "root";
$password = "rootroot";
$dbname = "comprasweb";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre_categoria = trim($_POST['nombre_categoria']);

        if (!empty($nombre_categoria)) {
            $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM CATEGORIA WHERE nombre = :nombre");
            $stmt->execute([':nombre' => $nombre_categoria]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['total'] > 0) {
                echo "Error: Ya existe una categoría con el nombre '$nombre_categoria'.";
            } else {
                if ($row['max_id'] != null) {
                    $ultimo_id = $row['max_id'];
                } else {
                    $ultimo_id = 'C-000';
                }
                $ultimo_numero = (int) substr($ultimo_id, 2);
                $nuevo_numero = $ultimo_numero + 1;
                $nuevo_id = 'C-' . str_pad($nuevo_numero, 3, '0', STR_PAD_LEFT);

                $stmt = $conn->prepare("INSERT INTO CATEGORIA (id_categoria, nombre) VALUES (:id_categoria, :nombre)");
                $stmt->execute([
                    ':id_categoria' => $nuevo_id,
                    ':nombre' => $nombre_categoria
                ]);

                echo "Categoría añadida con ID: $nuevo_id";
            }
        } else {
            echo "El nombre de la categoría no puede estar vacío.";
        }
    }
} catch (PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Alta de Categorías</title>
</head>

<body>
    <h1>Alta de Categorías</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="nombre_categoria">Nombre de la categoría:</label>
        <input type="text" id="nombre_categoria" name="nombre_categoria" required>
        <button type="submit">Agregar Categoría</button>
    </form>
</body>

</html>