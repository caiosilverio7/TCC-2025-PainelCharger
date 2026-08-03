<?php
session_start();

// 1. VERIFICAÇÃO DE AUTENTICAÇÃO (CRÍTICO)
// Se a variável de sessão 'usuario_id' não estiver definida, redireciona para o login.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Caso queira exibir o nome do usuário:
$nomeUsuario = $_SESSION['usuario_nome'] ?? "Usuário";

// Não há conexão com o BD aqui, então não é necessário incluir bd.php ou fechar a conexão.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Carregador Solar</title>
  <link rel="stylesheet" href="paginaprincipal.css">
  <style>
    /* Estilos para a barra superior e botão de logout */
    .top-bar {
      display: flex;
      justify-content: space-between; /* Ajustado para espaçar o nome e o botão */
      align-items: center;
      padding: 10px 20px;
      background-color: #f8f8f8;
      border-bottom: 1px solid #eee;
    }
    .welcome-text {
        font-weight: bold;
        color: #333;
    }
    .logout-btn {
      background-color: #dc3545; /* Vermelho mais moderno para 'Sair' */
      padding: 8px 15px;
      border: none;
      cursor: pointer;
      color: white;
      border-radius: 5px;
      transition: background-color 0.3s;
    }
    .logout-btn:hover {
      background-color: #c82333;
    }
    .main-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .planos {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }
    .planos button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 15px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1em;
        transition: background-color 0.3s, transform 0.1s;
        min-width: 150px;
    }
    .planos button:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }
    /* Estilos para o botão Sair, caso o clique não funcione */
    .logout-link {
        color: white;
        text-decoration: none;
    }
  </style>
</head>
<body>

  <!-- Barra superior com nome do usuário e botão sair -->
  <div class="top-bar">
    <span class="welcome-text">Olá <?php echo htmlspecialchars($nomeUsuario); ?></span>
    <!-- O clique do botão agora leva a um script de logout separado, mais limpo -->
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
      // Redireciona para a página de pagamento com o tempo comprado
      window.location.href = `pagamento.php?tempo=${tempo}`;
    }
  </script>
</body>
</html>