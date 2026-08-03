<?php
session_start();
// NOTA: Certifique-se de que 'bd.php' inclui a variável $conexao (objeto mysqli).
include('bd.php');

// 1. VERIFICAÇÃO DE AUTENTICAÇÃO
// Se o usuário não estiver logado, redireciona para o login.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Pega o ID do usuário logado
$usuario_id = $_SESSION['usuario_id'];

// Pega o tempo via GET e garante que é um inteiro
$tempo = isset($_GET['tempo']) ? (int)$_GET['tempo'] : 0;

$qr_code_path = '';
$pix_chave = '';
$valor = 0;

// 2. Define QR Code e chave Pix de acordo com o tempo e valor
switch ($tempo) {
    case 2: // R$1,50
        $qr_code_path = "imagens/qrcode5.png"; // Usando path local do usuário
        $pix_chave = "00020126330014BR.GOV.BCB.PIX01115454370584052040000530398654045.005802BR5901N6001C62190515PAINELCHARGER35630440AB";
        $valor = 1.50;
        break;
    case 10: // R$5,00
        $qr_code_path = "imagens/qrcode5.png"; // Usando path local do usuário
        $pix_chave = "00020126330014BR.GOV.BCB.PIX01115454370584052040000530398654045.005802BR5901N6001C62190515PAINELCHARGER35630440AB";
        $valor = 5.00;
        break;
    case 20: // R$10,00
        $qr_code_path = "imagens/qrcode10.png"; // Usando path local do usuário
        $pix_chave = "00020126330014BR.GOV.BCB.PIX011154543705840520400005303986540410.005802BR5901N6001C62190515PAINELCHARGER35630440AC"; 
        $valor = 10.00;
        break;
    case 30: // R$15,00
        $qr_code_path = "imagens/qrcode15.png"; // Usando path local do usuário
        $pix_chave = "00020126330014BR.GOV.BCB.PIX011154543705840520400005303986540515.005802BR5901N6001C62190515PAINELCHARGER3563041F1C"; 
        $valor = 15.00;
        break;
    case 60: // R$30,00
        $qr_code_path = "imagens/qrcode30.png"; // Usando path local do usuário
        $pix_chave = "00020126330014BR.GOV.BCB.PIX011154543705840520400005303986540530.005802BR5901N6001C62190515PAINELCHARGER35630410F6"; 
        $valor = 30.00;
        break;
    default:
        // Redireciona se o tempo for inválido
        header("Location: paginaprincipal.php");
        exit();
}

// O valor é usado como float no prepared statement, mas vamos garantir o formato.
$valor_decimal = (float)$valor; 

// 3. REGISTRA O PAGAMENTO DE FORMA SEGURA (USANDO PREPARED STATEMENTS)
$status_inicial = "pendente"; // Status inicial do pagamento
$sql = "INSERT INTO pagamentos (id_usuario, tempo, valor, status) VALUES (?, ?, ?, ?)";

// Prepara a consulta
$stmt = $conexao->prepare($sql);

if ($stmt === false) {
    die("Erro interno na preparação da consulta de pagamento: " . $conexao->error);
}

// 'i' = integer (id_usuario), 'i' = integer (tempo), 'd' = double/decimal (valor), 's' = string (status)
$stmt->bind_param("iids", $usuario_id, $tempo, $valor_decimal, $status_inicial);

// Executa a inserção no banco
if ($stmt->execute()) {
    // Salva o ID do pagamento recém-inserido na sessão para referência futura
    $_SESSION['last_payment_id'] = $conexao->insert_id;
} else {
    // Em caso de falha na inserção
    $erro_db = "Erro ao registrar o pagamento: " . $stmt->error;
    $stmt->close();
    $conexao->close();
    die($erro_db);
}

$sql = "insert into recarga(id_usuario,id_pagamento,situacao,data_inicio,data_fim,plano)
values('$usuario_id','".$_SESSION['last_payment_id']."','ativo',now(), DATE_ADD(NOW(), INTERVAL $tempo MINUTE),'$tempo minutos')";

$conexao->query($sql);
$stmt->close();
// Fecha a conexão antes de renderizar o HTML
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
     <link rel="stylesheet" href="pagamento.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Pagamento PIX</title>
    <!-- Adicionando estilos Tailwind para uma aparência moderna --><!-- Tenta carregar do CDN, e se falhar, não impede o script de carregar --><script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp" defer></script>
   
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center p-4 font-sans antialiased">

    <!-- Barra de Logout (Simples) --><div class="top-bar">
        <button onclick="window.location.href='sair.php'"
            class="logout-btn">
            Sair
        </button>
    </div>

    <div class="main-card">
        <h2 class="title">Finalizar Pagamento</h2>
        <p class="subtitle">Utilize o PIX para liberar a recarga de tempo.</p>
        
        <p class="info-text">
            Tempo de Recarga: <strong class="highlight-text"><?php echo $tempo; ?> minutos</strong>
        </p>
        <p class="value-text">
            Valor a pagar: <strong>R$<?php echo number_format($valor, 2, ',', '.'); ?></strong>
        </p>

        <!-- QR Code --><div class="qrcode-container">
            <img class="qrcode-image" 
                 src="<?php echo htmlspecialchars($qr_code_path); ?>" 
                 alt="QR Code PIX"
                 onerror="this.onerror=null; this.src='https://placehold.co/150x150/9CA3AF/ffffff?text=QR+Code';">
            <p class="qrcode-caption">Escaneie o QR Code no seu banco</p>
        </div>

        <!-- Chave Pix Copia e Cola --><div class="pix-copy-section">
            <strong>Opção 2: Copia e Cola</strong>
            
            <div id="pixKeyContainer" class="pix-key-container">
                <span id="pixKey" class="pix-key-text"><?php echo htmlspecialchars($pix_chave); ?></span>
            </div>
            
            <button onclick="copiarChave()" id="copyBtn"
                class="copy-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" />
                    <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2h2V5a2 2 0 012-2h6a2 2 0 00-2-2H5z" />
                </svg>
                Copiar Chave PIX
            </button>
            
            <!-- Mensagem de feedback de cópia --><div id="feedback-msg">Chave PIX copiada com sucesso!</div>
        </div>

        <hr>

        <!-- Botão de Confirmação --><button onclick="window.location.href='carregando.php?tempo=<?php echo $tempo; ?>'"
            class="confirm-button">
            ✅ Já fiz o PIX - Continuar
        </button>
        
        <p class="footer-text">A recarga será liberada automaticamente após a confirmação do pagamento.</p>

    </div>

    <script>
    function copiarChave() {
        const pixKeyElement = document.getElementById("pixKey");
        const feedbackMsg = document.getElementById("feedback-msg");
        const chave = pixKeyElement.innerText;
        
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(chave).then(function() {
                showFeedback("Chave PIX copiada com sucesso!");
            }).catch(function(err) {
                fallbackCopyTextToClipboard(chave);
                showFeedback("Chave copiada (método fallback).");
            });
        } else {
            fallbackCopyTextToClipboard(chave);
            showFeedback("Chave copiada (método fallback).");
        }
    }
    
    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed"; 
        textArea.style.top = 0; 
        textArea.style.left = 0;
        textArea.style.width = '2em';
        textArea.style.height = '2em';
        textArea.style.padding = 0;
        textArea.style.border = 'none';
        textArea.style.outline = 'none';
        textArea.style.boxShadow = 'none';
        textArea.style.background = 'transparent';
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
        } catch (err) {
            console.error('Fallback: Falha ao copiar', err);
        }
        document.body.removeChild(textArea);
    }
    
    function showFeedback(message) {
        const feedbackMsg = document.getElementById("feedback-msg");
        feedbackMsg.innerText = message;
        
        feedbackMsg.style.display = 'block';
        
        requestAnimationFrame(() => feedbackMsg.style.opacity = '1');
        
        setTimeout(() => {
            feedbackMsg.style.opacity = '0';
            setTimeout(() => feedbackMsg.style.display = 'none', 500);
        }, 3000);
    }
    </script>
</body>
</html>