<?php
$servername = "localhost";
$username = "root";
$password = "";
$BD= "agendamento_consultas";
try {
  $conn = new PDO("mysql:host=$servername;dbname=$BD", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
