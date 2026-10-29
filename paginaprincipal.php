<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$nomeUsuario = $_SESSION['usuario_nome'] ?? "Usuário";

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Carregador Solar</title>
  <link rel="stylesheet" href="paginaprincipal.css">
</head>
<body>

  <div class="top-bar">
    <span class="welcome-text">Olá, <?php echo htmlspecialchars($nomeUsuario); ?>!</span>
    <button class="logout-btn" onclick="window.location.href='sair.php'">Sair</button>
  </div>

  <div class="main-container">
    <h1>Carregador Solar Público</h1>
    

    <p>Escolha quanto tempo você quer carregar seu celular:</p>

    <div class="planos">
      <button onclick="comprar(2)">2 minutos - R$1,50</button>
      <button onclick="comprar(10)">10 minutos - R$5,00</button>
      <button onclick="comprar(20)">20 minutos - R$10,00</button>
      <button onclick="comprar(30)">30 minutos - R$15,00</button>
      <button onclick="comprar(60)">1 hora - R$30,00</button>
    </div>

    <div id="mensagem-compra"></div>
  </div>

  <script>
    function comprar(tempo) {
      window.location.href = `pagamento.php?tempo=${tempo}`;
    }
  </script>
</body>
</html>