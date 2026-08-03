<?php
session_start();

// Inclui o arquivo de conexão. $conexao é uma instância de mysqli
include "bd.php";

$erro = null;

// Processa login se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'], $_POST['senha'])) {
    
    $email = strtolower(trim($_POST['email']));
    $senha = $_POST['senha'];

    // 1. Prepara a consulta para buscar o usuário APENAS pelo e-mail.
    // Usamos Prepared Statements para evitar SQL Injection.
    $stmt = $conexao->prepare("SELECT id_usuario, nome, email, senha FROM usuarios WHERE email = ?");
    
    if ($stmt === false) {
        $erro = "Erro interno na preparação da consulta: " . $conexao->error;
    } else {
        $stmt->bind_param("s", $email); // 's' para string
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $linha = $res->fetch_object();
            $hash_senha = $linha->senha;

            // 2. Verifica a senha usando a função password_verify()
            // Isso garante compatibilidade com o password_hash() usado no cadastro.
            if (password_verify($senha, $hash_senha)) {
                
                // Login bem-sucedido
                $_SESSION['usuario_id']   = $linha->id_usuario; // Usando o nome da coluna correto: id_usuario
                $_SESSION['email']        = $linha->email;
                $_SESSION['usuario_nome'] = $linha->nome;
                
                // Fecha o statement e a conexão antes de redirecionar
                $stmt->close();
                $conexao->close();
                
                header("Location: paginaprincipal.php");
                exit();
                
            } else {
                // Senha incorreta
                $erro = "Email ou senha inválidos!";
            }
        } else {
            // Usuário não encontrado
            $erro = "Email ou senha inválidos!";
        }
        
        $stmt->close();
    }
    
    // 3. Se houve erro, armazena na sessão e redireciona com o parâmetro de erro
    if ($erro) {
        $_SESSION['erro_login'] = $erro;
        // Fecha a conexão
        $conexao->close();
        header("Location: login.php?erro=1");
        exit();
    }
}

// Verifica se há mensagem de erro na sessão para exibir, se o redirecionamento
// de erro tiver acabado de ocorrer.
$erro_exibir = null;
if (isset($_SESSION['erro_login'])) {
    $erro_exibir = $_SESSION['erro_login'];
    unset($_SESSION['erro_login']);
}

// Se chegou direto na página sem enviar formulário, só exibe o formulário abaixo
// A conexão é fechada antes de o script terminar.
if (isset($conexao) && $conexao instanceof mysqli) {
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Carregador Solar</title>
    <!-- Inclui seus estilos CSS -->
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="estilos.css">
    <style>
/* Estilos básicos para a mensagem de erro */
#msgErro { 
    padding: 10px; 
    background-color: #fdd; 
    border: 1px solid #f00; 
    color: #a00; 
    text-align: center; 
    margin-bottom: 20px; 
    border-radius: 5px;
    opacity: 0; /* Começa invisível */
    transition: opacity 0.5s ease; /* Adiciona transição para o JS */
}
.login-container { 
    max-width: 400px; 
    margin: 50px auto; 
    padding: 20px; 
    border: 1px solid #ccc; 
    border-radius: 8px; 
    box-shadow: 0 0 10px rgba(0,0,0,0.1); 
}
.input-field { margin-bottom: 20px; }
.input-field input { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
.btn-field { text-align: center; }
.btn-field button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
</style>
</head>
<body>

    <div class="login-container">

        <!-- Mensagem de erro que exibe a variável PHP (se setada pela sessão) -->
        <?php if ($erro_exibir): ?>
            <div id="msgErro" style="display:block; opacity:1;"><?php echo htmlspecialchars($erro_exibir); ?></div>
        <?php else: ?>
            <!-- Elemento que será manipulado pelo JavaScript se houver um erro na URL -->
            <div id="msgErro" style="display:none;">Email ou senha inválidos!</div>
        <?php endif; ?>


        <script>
        // Esta função JavaScript agora verifica o parâmetro 'erro=1'
        // e exibe a mensagem de erro (usando o elemento HTML padrão).
        const params = new URLSearchParams(window.location.search);
        if (params.get('erro') === '1') {
            const msg = document.getElementById('msgErro');
            if (msg) {
                // Se a mensagem não foi setada pelo PHP ($erro_exibir), 
                // garantimos que o texto padrão seja exibido
                if (msg.textContent === 'Email ou senha inválidos!' || msg.textContent === '') {
                    msg.textContent = "Email ou senha inválidos!";
                }
                msg.style.display = 'block';
                // Usamos JS para definir a opacidade para 1, acionando a transição CSS
                requestAnimationFrame(() => {
                    msg.style.opacity = '1'; 
                });

                // Remove a mensagem após 4 segundos (efeito fade out)
                setTimeout(() => {
                    msg.style.opacity = '0';
                    // Esconde o elemento após a transição
                    setTimeout(() => msg.style.display = 'none', 500); // 500ms é um bom tempo para a transição
                }, 4000);
            }
        }
        </script>

        <form action="login.php" method="post">

            <h2>Login</h2>
            
            <div class="input-field">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            
            <div class="input-field">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>

            <div class="btn-field">
                <button type="submit">Entrar</button>
            </div>

            <p><a href="cadastro.php">Cadastre-se aqui</a></p>
        </form>
    </div>
</body>
</html>