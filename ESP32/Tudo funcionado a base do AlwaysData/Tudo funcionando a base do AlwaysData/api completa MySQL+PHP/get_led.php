<?php 
header("Content-Type: text/plain");
header("Content-Disposition: inline; filename=status.txt");
$host = "mysql-safebike-server.alwaysdata.net";
$user = "424415";
$password = "rianlindao2";
$dbname = "safebike-server_esp32_control";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$result = $conn->query("SELECT status FROM led_status ORDER BY id DESC LIMIT 1");

if ($result && $row = $result->fetch_assoc()) {
    echo $row['status'];
} else {
    echo "Sem dados ainda.";
}

$conn->close();
?>