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
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_producto = $_POST['id_producto'];

        
    }
} catch (PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}

?>