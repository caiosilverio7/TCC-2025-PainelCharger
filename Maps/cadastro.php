<?php
include("conexao.php");

if (isset($_POST["nome"])) {
    $nome         = $_POST["nome"];
    $endereco     = htmlspecialchars($_POST["endereco"]);
    $detalhes     = htmlspecialchars($_POST["detalhes"]);
    $latitude     = $_POST["latitude"];
    $longitude    = $_POST["longitude"];
    $id_categoria = $_POST["id_categoria"];

    $sql = "INSERT INTO estabelecimentos (nome, endereco, detalhes, latitude, longitude, id_categoria)
            VALUES ('$nome', '$endereco', '$detalhes', '$latitude', '$longitude', '$id_categoria');";

    $resultado = $conexao->query($sql);

    echo "<div id='msgSucesso'>Cadastrado com sucesso!</div>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Cadastro de Estabelecimentos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZeaB6_44Hq2G5Pfj34_HOgsi5sNuPGoA&sensor=true"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #111;
      color: white;
      background-image: url("Imagens/fundo.png");
      background-repeat: no-repeat;
      background-position: center center;
      background-size: 100% auto;
    }

    .cadastro-container {
      max-width: 500px;
      margin: 100px auto;
      background-color: #1a1a1a;
      padding: 2em;
      border-radius: 15px;
      text-align: center;
      border: 2px solid #888888;
      box-shadow: 0 0 20px rgba(136, 136, 136, 0.6);
    }

    h2 {
      color: #bbbbbb;
      margin-bottom: 20px;
    }

    label {
      display: block;
      text-align: left;
      margin-top: 15px;
      color: #bbbbbb;
    }

    input, select {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      border: 2px solid #888888;
      border-radius: 10px;
      background-color: #000;
      color: white;
      font-size: 16px;
      transition: 0.2s;
    }

    input:focus, select:focus {
      outline: none;
      border-color: #bbbbbb;
      box-shadow: 0 0 5px #bbbbbb;
    }

    button {
      width: 100%;
      padding: 12px;
      margin-top: 20px;
      background-color: #888888;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #666666;
    }

    #msgSucesso {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #4CAF50;
      color: white;
      padding: 15px 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(76, 175, 80, 0.7);
      font-weight: bold;
      font-size: 16px;
      animation: fadeInOut 4s forwards;
      z-index: 1000;
    }

    @keyframes fadeInOut {
      0% { opacity: 0; }
      10% { opacity: 1; }
      90% { opacity: 1; }
      100% { opacity: 0; }
    }
  </style>

  <script>
    var geocoder;

    $(document).ready(function() {
      $("#endereco").change(function() {
        var endereco = $(this).val();
        if (endereco != "") {
          carregarNoMapa(endereco);
        } else {
          alert("Informe um endereço válido!");
        }
      });

      function carregarNoMapa(endereco) {
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, function (results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              var latitude = results[0].geometry.location.lat();
              var longitude = results[0].geometry.location.lng();

              $('#endereco').val(results[0].formatted_address);
              $('#latitude').val(latitude);
              $('#longitude').val(longitude);
            }
          }
        });
      }
    });
  </script>
</head>

<body>
  <div class="cadastro-container">
    <h2>Cadastro de Estabelecimentos</h2>

    <form action="cadastro.php" method="post">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" placeholder="Informe o nome" required>

      <label for="endereco">Endereço:</label>
      <input type="text" id="endereco" name="endereco" placeholder="Informe o endereço" required>

      <label for="latitude">Latitude:</label>
      <input type="text" id="latitude" name="latitude" placeholder="Latitude" readonly>

      <label for="longitude">Longitude:</label>
      <input type="text" id="longitude" name="longitude" placeholder="Longitude" readonly>

      <label for="detalhes">Detalhes:</label>
      <input type="text" id="detalhes" name="detalhes" placeholder="Detalhes sobre o estabelecimento">

      <label for="id_categoria">Categoria:</label>
      <select name="id_categoria" id="id_categoria" required>
        <?php
          $resultado = $conexao->query("SELECT * FROM categorias ORDER BY nome");
          while ($linha = $resultado->fetch_object()) {
            echo "<option value=\"$linha->id_categoria\">" . utf8_encode($linha->nome) . "</option>";
          }
        ?>
      </select>

      <button type="submit">Cadastrar</button>
    </form>
  </div>
</body>
</html>
