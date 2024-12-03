<?php
$host = "localhost";
$username = "root";
$password = "rootroot";
$dbname = "comprasweb";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT id_categoria, nombre FROM CATEGORIA ORDER BY nombre");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $categorias = $stmt->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre_producto = trim($_POST['nombre_producto']);
        $precio = $_POST['precio'];
        $id_categoria = $_POST['id_categoria'];
        
        if (!empty($nombre_producto) && !empty($id_categoria)) {
            $stmt = $conn->prepare("SELECT MAX(id_producto) AS max_id FROM PRODUCTO");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['max_id'] != null) {
                $ultimo_id = $row['max_id'];
            } else {
                $ultimo_id = 'P0000'; // Si no hay productos se inicia con P0000
            }

            $ultimo_numero = (int) substr($ultimo_id, 1);
            $nuevo_numero = $ultimo_numero + 1;
            $nuevo_id = 'P' . str_pad($nuevo_numero, 4, '0', STR_PAD_LEFT);

            // Insertar el nuevo producto
            $stmt = $conn->prepare("INSERT INTO PRODUCTO (id_producto, nombre, precio, id_categoria) VALUES (:id_producto, :nombre, :precio, :id_categoria)");
            $stmt->execute([
                ':id_producto' => $nuevo_id,
                ':nombre' => $nombre_producto,
                ':precio' => $precio,
                ':id_categoria' => $id_categoria
            ]);

            echo "Producto añadido con ID: $nuevo_id";
        } else {
            echo "Todos los campos son obligatorios";
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
    <title>Alta de Productos</title>
</head>

<body>
    <h1>Alta de Productos</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="nombre_producto">Nombre del producto:</label>
        <input type="text" id="nombre_producto" name="nombre_producto" required><br><br>

        <label for="precio">Precio:</label>
        <input type="text" id="precio" name="precio" required><br><br>

        <label for="id_categoria">Categoría:</label>
        <select id="id_categoria" name="id_categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php
            foreach ($categorias as $categoria) {
                echo '<option value="' . htmlspecialchars($categoria['id_categoria']) . '">';
                echo htmlspecialchars($categoria['nombre']);
                echo '</option>';
            }
            ?>
        </select><br><br>

        <button type="submit">Agregar Producto</button>
    </form>
</body>

</html>