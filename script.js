function comprar(tempo) {
    let preco = tempo / 2;
    const msg = `Você escolheu ${tempo} minutos por R$${preco}. (Simulação de compra)`;
    document.getElementById("mensagem-compra").innerText = msg;
  }
  