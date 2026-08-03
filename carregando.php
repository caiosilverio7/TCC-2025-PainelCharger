<?php
session_start();
include('bd.php'); // Certifique-se que este arquivo inicializa a variável $conexao

// 1. Inicialização de variáveis e conversão para inteiro
$usuario_id = isset($_SESSION['usuario_id']) ? (int)$_SESSION['usuario_id'] : 0;
// Obtém o ID do pagamento que foi salvo no pagamento.php
$id_pagamento = isset($_SESSION['last_payment_id']) ? (int)$_SESSION['last_payment_id'] : 0;
// Obtém o tempo da URL
$tempo_minutos = isset($_GET['tempo']) ? (int)$_GET['tempo'] : 0;

// 2. VALIDAÇÃO CRÍTICA (Se algum ID estiver faltando, ele redireciona)
if ($usuario_id <= 0 || $tempo_minutos <= 0 || $id_pagamento <= 0) {
    // Se a validação falhar, ele volta. Isso resolve o problema de redirecionamento.
    header("Location: paginaprincipal.php?erro=dados_invalidos"); 
    exit();
}

// 3. Definição de datas e plano
$data_inicio = date('Y-m-d H:i:s');
$data_fim = date('Y-m-d H:i:s', strtotime("+{$tempo_minutos} minutes"));
$plano = "{$tempo_minutos} minutos";
$status_ativo = 'ativa';
$status_expirado = 'expirada'; // Use 'expirada' ou 'inativo'

// 5. Variável para o timer JS (tempo em segundos)
$segundos_restantes = $tempo_minutos * 60;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" href="carregando.css">
    <meta charset="UTF-8">
    <title>Carregando...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
    <div class="top-bar">
         <button onclick="window.location.href='sair.php'"
            class="logout-btn">
            Sair
        </button>
    </div>
    <div class="container">
        <h2>Painel Charger ativado, você já pode conectar seu dispositivo para carregar.</h2>
        <p>Tempo restante: <strong><span id="timer"></span></strong></p>
    </div>

    <script>
    let tempo = <?php echo $segundos_restantes; ?>;

    function formatarTempo(segundos) {
        let min = Math.floor(segundos / 60);
        let sec = segundos % 60;
        return (min < 10 ? "0" : "") + min + ":" + (sec < 10 ? "0" : "") + sec;
    }

    function atualizarTimer() {
        if (tempo >= 0) {
            document.getElementById("timer").innerText = formatarTempo(tempo);
            tempo--;
        } else {
            clearInterval(intervalo);
            window.location.href = "cargafinalizada.php";
        }
    }

    let intervalo = setInterval(atualizarTimer, 1000);
    atualizarTimer();
    </script>
</body>
</html>