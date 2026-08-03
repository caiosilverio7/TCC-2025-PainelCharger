<?php
$host = "mysql-safebike-server.alwaysdata.net";
$user = "424415";
$password = "rianlindao2";
$dbname = "safebike-server_esp32_control";

// Verifica se o parâmetro foi enviado via POST
if (!isset($_POST['status'])) {
    http_response_code(400);
    echo "Parâmetro 'status' ausente";
    exit;
}

$status = $_POST['status'];

// Verifica se o valor é válido
if ($status !== 'on' && $status !== 'off') {
    http_response_code(400);
    echo "Status inválido";
    exit;
}

// Conecta ao banco
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Insere o novo status
$sql = "INSERT INTO led_status (status) VALUES ('$status')";
if ($conn->query($sql) === TRUE) {
    echo "Status atualizado para: $status";
} else {
    echo "Erro ao atualizar status: " . $conn->error;
}

$conn->close();
?>