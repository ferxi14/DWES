<?php
$host = "localhost";
$username = "root";
$password = "rootroot";
$dbname = "comprasweb";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT id_producto, nombre FROM PRODUCTO");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT num_almacen, localidad FROM ALMACEN");
    $stmt->execute();
    $almacenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_producto = $_POST["id_producto"];
        $num_almacen = $_POST["num_almacen"];
        $cantidad = (int) $_POST["cantidad"];

        if (!empty($id_producto) && !empty($num_almacen) && $cantidad > 0) {
            $stmt = $conn->prepare(
                "INSERT INTO ALMACENA (num_almacen, id_producto, cantidad)
                 VALUES (:num_almacen, :id_producto, :cantidad)
                 ON DUPLICATE KEY UPDATE cantidad = cantidad + :cantidad"
            );
            $stmt->execute([
                ':num_almacen' => $num_almacen,
                ':id_producto' => $id_producto,
                ':cantidad' => $cantidad
            ]);

            echo "Producto aprovisionado";
        } else {
            echo "Error: Debes rellenar todos los campos";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Aprovisionar Productos</title>
</head>

<body>
    <h1>Aprovisionar Productos</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="id_producto">Producto:</label>
        <select id="id_producto" name="id_producto" required>
            <option value="">-- Seleccione un producto --</option>
            <?php foreach ($productos as $producto): ?>
                <option value="<?= htmlspecialchars($producto['id_producto']) ?>">
                    <?= htmlspecialchars($producto['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="num_almacen">Almacén:</label>
        <select id="num_almacen" name="num_almacen" required>
            <option value="">-- Seleccione un almacén --</option>
            <?php foreach ($almacenes as $almacen): ?>
                <option value="<?= htmlspecialchars($almacen['num_almacen']) ?>">
                    <?= htmlspecialchars($almacen['localidad']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" min="1" required>
        <br><br>

        <button type="submit">Aprovisionar</button>
    </form>
</body>

</html>