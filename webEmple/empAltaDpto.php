<?php
$servername = "localhost";
$username = "root";
$password = "rootroot";
$dbname = "empleadosnn";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nomdpto = $_POST['nomdpto'];

    $sql = "SELECT MAX(COD_DPTO) AS max_code FROM DEPARTAMENTO";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['max_code']) {
        $last_number = (int) substr($row['max_code'], 1); // Extraer el número, sin la 'D'
        $new_number = $last_number + 1;
    } else {
        $new_number = 1; // Iniciar en 1 si no hay departamentos existentes
    }
    
    $cod_dpto = 'D' . str_pad($new_number, 3, '0', STR_PAD_LEFT); 

    $sql = "INSERT INTO DEPARTAMENTO (COD_DPTO, NOMBRE_DPTO) VALUES (:cod_dpto, :nombre_dpto)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cod_dpto', $cod_dpto);
    $stmt->bindParam(':nombre_dpto', $nombre_dpto);

    if ($stmt->execute()) {
        echo "Departamento creado con éxito: Código - $cod_dpto, Nombre - $nombre_dpto";
    } else {
        echo "Error al crear el departamento.";
    }
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn= null;

?>