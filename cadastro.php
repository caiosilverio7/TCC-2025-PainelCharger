<?php
// Inicia a sessão para gerenciamento de mensagens de erro
session_start();
// Inclui o arquivo de conexão com o banco de dados
// A variável $conexao será a instância de mysqli (ou PDO)
include "bd.php";

$erro = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = trim($_POST['nome']);
    $email = strtolower(trim($_POST['email']));
    $senha = $_POST['senha'];
    // Remove qualquer caractere que não seja dígito do CPF
    $cpf   = preg_replace('/\D/', '', $_POST['cpf']);

    // 1. Validação de campos obrigatórios
    if (empty($nome) || empty($email) || empty($senha) || empty($cpf)) {
        $erro = "Todos os campos são obrigatórios.";
    }

    // 2. Validação de CPF (11 dígitos)
    if (!$erro && strlen($cpf) !== 11) {
        $erro = "O CPF deve conter 11 dígitos.";
    }

    // 3. Validação de formato de e-mail (básico)
    if (!$erro && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Formato de e-mail inválido.";
    }

    // 4. Validação de senha mínima (pelo menos 8 caracteres)
    if (!$erro && strlen($senha) < 8) {
        $erro = "A senha deve ter pelo menos 8 caracteres.";
    }

    // --- Verificações de Unicidade com Prepared Statements (Segurança!) ---

    // 5. Verifica se o e-mail já está cadastrado
    if (!$erro) {
        // Uso de prepared statement para evitar SQL Injection
        $stmt_email = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $stmt_email->bind_param("s", $email); // 's' indica que o parâmetro é uma string
        $stmt_email->execute();
        $resultadoEmail = $stmt_email->get_result();

        if ($resultadoEmail->num_rows > 0) {
            $erro = "Este e-mail já está registrado.";
        }
        $stmt_email->close();
    }

    // 6. Verifica se o CPF já está cadastrado
    if (!$erro) {
        // Uso de prepared statement para evitar SQL Injection
        $stmt_cpf = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE cpf = ?");
        $stmt_cpf->bind_param("s", $cpf); // 's' indica que o parâmetro é uma string
        $stmt_cpf->execute();
        $resultadoCpf = $stmt_cpf->get_result();

        if ($resultadoCpf->num_rows > 0) {
            $erro = "Este CPF já está cadastrado.";
        }
        $stmt_cpf->close();
    }

    // 7. Insere no banco com senha hasheada
    if (!$erro) {
        // Hashing seguro da senha usando o algoritmo padrão (Bcrypt ou similar)
        // ESSENCIAL para segurança!
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Uso de prepared statement para inserção
        $sqlInserir = "
            INSERT INTO usuarios (nome, email, cpf, senha)
            VALUES (?, ?, ?, ?)
        ";
        $stmt_inserir = $conexao->prepare($sqlInserir);
        $stmt_inserir->bind_param("ssss", $nome, $email, $cpf, $senhaHash);

        if ($stmt_inserir->execute()) {
            // Sucesso! Redireciona para a página de login
            $stmt_inserir->close();
            // Garante que a conexão seja fechada antes do redirecionamento
            $conexao->close(); 
            header("Location: login.php");
            exit();
        } else {
            $erro = "Erro interno ao cadastrar: " . $conexao->error; // Adicionando erro de BD para debug
        }
        $stmt_inserir->close();
    }

    // 8. Se houver erro, armazena na sessão e redireciona
    if ($erro) {
        $_SESSION['erro'] = $erro;
        // Garante que a conexão seja fechada antes do redirecionamento
        $conexao->close();
        header("Location: cadastro.php");
        exit();
    }
}

// Mensagem de erro para exibição no formulário
if (isset($_SESSION['erro'])) {
    $erro = $_SESSION['erro'];
    unset($_SESSION['erro']);
}

// Verifica se a conexão $conexao está aberta (para fechar no final do script se não houve redirecionamento)
if (isset($conexao) && $conexao instanceof mysqli) {
    $conexao->close();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro - Carregador Solar</title>
<!-- Você deve garantir que 'cadastro.css' esteja presente -->
<link rel="stylesheet" href="cadastro.css"> 
<style>
/* Estilos básicos para o indicador de força da senha */
#indicadorForca { margin-top: 5px; height: 10px; background-color: #eee; border-radius: 5px; overflow: hidden; }
#barraForca { height: 100%; transition: width 0.3s, background-color 0.3s; width: 0%; }
#textoForca { font-size: 0.8em; margin-top: 5px; display: block; }
#msgErro { padding: 10px; background-color: #fdd; border: 1px solid #f00; color: #a00; text-align: center; margin-bottom: 10px; border-radius: 5px; }
.cadastro-container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
.input-field { margin-bottom: 20px; }
.input-field input { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
.btn-field { text-align: center; }
.btn-field button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
.btn-field button:disabled { background-color: #aaa; cursor: not-allowed; }
</style>
</head>
<body>

<?php if ($erro): ?>
<div id="msgErro" style="display:block;"><?php echo htmlspecialchars($erro); ?></div>
<?php endif; ?>

<div class="cadastro-container">
<form action="cadastro.php" method="POST" id="formCadastro" novalidate>

<h2>Cadastro</h2>

<div class="input-field">
<input type="text" name="nome" id="nome" placeholder="Nome" required 
       value="<?php echo isset($nome) ? htmlspecialchars($nome) : ''; ?>">
<small class="erro"></small>
</div>

<div class="input-field">
<input type="email" name="email" id="email" placeholder="Email" required
       value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
<small class="erro"></small>
</div>

<div class="input-field">
<input type="text" name="cpf" id="cpf" maxlength="14" oninput="mascaraCPF(this)" placeholder="CPF" required
       value="<?php echo isset($cpf) ? htmlspecialchars($cpf) : ''; ?>">
<small class="erro"></small>
</div>

<div class="input-field">
<input type="password" name="senha" id="senha" placeholder="Senha" required onkeyup="checarForcaSenha(this.value)">
<div id="indicadorForca">
  <div id="barraForca"></div>
  <span id="textoForca">Força: </span>
</div>
<small class="erro"></small>
</div>

<div class="btn-field">
<button type="submit" id="btnCadastrar" disabled>Cadastrar</button>
</div>

<p><a href="login.php">Já tem conta? Faça login aqui.</a></p>

</form>
</div>

<script>
// máscara do CPF
function mascaraCPF(campo) {
  let v = campo.value.replace(/\D/g, "");
  v = v.replace(/(\d{3})(\d)/, "$1.$2");
  v = v.replace(/(\d{3})(\d)/, "$1.$2");
  v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
  campo.value = v;
}

// força da senha
function checarForcaSenha(senha) {
  const barra = document.getElementById('barraForca');
  const texto = document.getElementById('textoForca');
  const btn = document.getElementById('btnCadastrar');

  let forca = 0;
  if (senha.length >= 8) forca++;
  if (/[A-Z]/.test(senha)) forca++;
  if (/[a-z]/.test(senha)) forca++;
  if (/\d/.test(senha)) forca++;
  if (/[^A-Za-z0-9]/.test(senha)) forca++;

  if (forca <= 2) {
    barra.style.width = '33%';
    barra.style.background = 'red';
    texto.innerHTML = 'Força: Fraca';
    btn.disabled = true;
  } else if (forca === 3 || forca === 4) {
    barra.style.width = '66%';
    barra.style.background = 'orange';
    texto.innerHTML = 'Força: Média';
    btn.disabled = false;
  } else {
    barra.style.width = '100%';
    barra.style.background = 'green';
    texto.innerHTML = 'Força: Forte';
    btn.disabled = false;
  }
}
</script>

</body>
</html>