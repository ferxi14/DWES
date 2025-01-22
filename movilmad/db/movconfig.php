<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'rootroot');
   define('DB_DATABASE', 'movilmad');
  
   function conexionDB() {
      try {
          $pdo = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
          return $pdo;
      } catch (PDOException $e) {
          die("ERROR: No se pudo conectar a la base de datos. " . $e->getMessage());
      }
  }
?>