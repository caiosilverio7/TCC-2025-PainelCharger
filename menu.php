<?php
// menu.php (ou index.php) - Página Principal
session_start();

// Verifica se o usuário está logado
$logado = isset($_SESSION['id_usuario']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" href="menu.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Charger 35 | Solução Sustentável de Recarga</title>
    <link rel="stylesheet" href="estilo.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <i class="fas fa-bolt"></i> **Charger 35**
            <span class="tagline">Soluções em Energia Inteligente</span>
        </div>
        <nav>
            <a href="#sobre">A Solução</a>
            <a href="#mapa">Onde Encontrar</a>
            <?php if ($logado): ?>
                <a href="pagamento.php">Contratar Recarga</a>
                <a href="carregando.php">Monitorar Uso</a>
                <a href="logout.php" class="nav-logout-btn">Sair (<?php echo $_SESSION['nome_usuario'] ?? 'Usuário'; ?>)</a>
            <?php else: ?>
                <a href="cadastro.php">Cadastro</a>
                <a href="login.php?redirect=pagamento.php">Planos</a>
                <a href="paginaprincipal.php">Painel (TCC)</a>
            <?php endif; ?>
        </nav>
        <?php if (!$logado): ?>
            <button class="login-btn" onclick="window.location.href='login.php'">Acesso ao Cliente</button>
        <?php else: ?>
            <button class="action-btn" onclick="window.location.href='pagamento.php'">CONTRATAR RECARGA</button>
        <?php endif; ?>
    </header>

    <section class="hero-formal">
        <div class="hero-content">
            <h1>Infraestrutura de Recarga **100% Solar** para o Setor Público</h1>
            <p>Viabilize a mobilidade sustentável e a conectividade urbana com a inovação Painel Charger 35.</p>
            <?php if (!$logado): ?>
                <button onclick="window.location.href='login.php'" class="main-cta">Acessar Plataforma & Planos</button>
            <?php else: ?>
                <button onclick="window.location.href='pagamento.php'" class="main-cta">CONTRATAR RECARGA AGORA</button>
            <?php endif; ?>
        </div>
            </section>

---

    <section id="sobre" class="sobre-formal">
        <h2>A Solução: **Conectividade Urbana Sustentável**</h2>
        <p>
            O **Painel Charger 35** é o resultado de um Trabalho de Conclusão de Curso (TCC) focado em resolver um problema crucial da vida urbana: a falta de energia em dispositivos móveis em momentos críticos. Nossa proposta é uma estação de recarga pública, robusta e alimentada integralmente por energia solar, incentivando o uso de tecnologias limpas.
        </p>
        <div class="metrics">
            <div class="metric-item">
                <i class="fas fa-solar-panel"></i> <span>Energia Limpa</span>
                <p>100% de autonomia e geração fotovoltaica.</p>
            </div>
            <div class="metric-item">
                <i class="fas fa-plug-circle-bolt"></i> <span>Tecnologia Híbrida</span>
                <p>Compatibilidade total: indução (wireless) e conexões USB/Tipo-C.</p>
            </div>
            <div class="metric-item">
                <i class="fas fa-lock"></i> <span>Segurança de Dados</span>
                <p>Sistema de controle de acesso (login) e gestão de uso via ESP-32.</p>
            </div>
        </div>
    </section>

---

    <section id="mapa" class="funcionalidades-formal">
        <h2>Funcionalidades Chave da Plataforma</h2>
        <div class="cards-func">
            <div class="card-func" onclick="window.location.href='login.php?redirect=pagamento.php'">
                <h3><i class="fas fa-credit-card"></i> **Gestão de Recargas**</h3>
                <p>Contrate o tempo de uso via PIX/Cartão e inicie a recarga instantaneamente no painel.</p>
            </div>
            <div class="card-func" onclick="window.location.href='maps.php'">
                <h3><i class="fas fa-map-marked-alt"></i> **Localizador de Estações**</h3>
                <p>Use o **Maps** para visualizar a disponibilidade e localização exata dos Painéis Charger 35.</p>
            </div>
            <div class="card-func" onclick="window.location.href='login.php?redirect=carregando.php'">
                <h3><i class="fas fa-clock"></i> **Monitoramento do Tempo**</h3>
                <p>Acompanhe o temporizador de recarga no site, que é sincronizado em tempo real com o ESP-32.</p>
            </div>
        </div>
    </section>

---

    <section class="cta-contato">
        <h2>Pronto para Implementar a Inovação?</h2>
        <p>Conheça os detalhes técnicos do projeto (TCC) e explore a viabilidade de implementação em sua cidade ou campus.</p>
        <button onclick="window.location.href='paginaprincipal.php'" class="secondary-cta">Ver Relatório Técnico (TCC)</button>
    </section>

    <footer>
        <p>© 2025 Grupo Educacional Opção | Painel Charger 35. Todos os direitos reservados. | Desenvolvido com PHP, MySQL e ESP-32.</p>
    </footer>
</body>
</html>