<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Consultar Estabelecimentos</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Scripts do Bootstrap e Google Maps -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

    .container {
      max-width: 900px;
      margin: 80px auto;
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

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #444;
    }

    th {
      background-color: #222;
      color: #bbbbbb;
    }

    tr:hover {
      background-color: #2a2a2a;
    }

    button {
      padding: 10px 15px;
      background-color: #888888;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #666666;
    }

    #mapa {
      width: 100%;
      height: 500px;
      border: 4px solid #888888;
      border-radius: 10px;
      margin-top: 30px;
      display: none;
      box-shadow: 0 0 15px rgba(136, 136, 136, 0.4);
    }

    #msgErro {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #f44336;
      color: white;
      padding: 15px 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(244, 67, 54, 0.7);
      opacity: 0;
      z-index: 1000;
      font-weight: bold;
      font-size: 16px;
    }
  </style>

  <script>
    var geocoder;
    var map;
    var marker;

    var Titulo;
    var Texto;
    
    function exibeMapa(latitude, longitude) {
      var latlng = new google.maps.LatLng(latitude, longitude);
      var options = {
        zoom: 15,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      
      map = new google.maps.Map(document.getElementById("mapa"), options);
      
      geocoder = new google.maps.Geocoder();
      
      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        icon: 'pessoa.png'
      });

      const BlocoDiv = "<div><h1>" + Titulo + "</h1><p>" + Texto + "</p></div>";

      const infowindow = new google.maps.InfoWindow({
        content: BlocoDiv,
      });
      
      marker.setPosition(latlng);

      marker.addListener("click", () => {
        infowindow.open({
          anchor: marker,
          map,
          shouldFocus: false,
        });
      });
    }
    
    $(document).ready(function(){
      $(".btn").click(function(){
        var latitude  = $(this).attr('lat');
        var longitude = $(this).attr('long');
        Titulo = $(this).attr('Titulo');
        Texto  = $(this).attr('Texto');
        
        $("#mapa").show();
        exibeMapa(latitude, longitude);
      });
    });
  </script>
</head>

<body>
  <div class="container">
    <h2>Busca de Estabelecimentos</h2>
    
    <?php
      include("conexao.php");
      $sql = "select * from estabelecimentos order by Nome";
      $resultado = $conexao->query($sql);
      
      echo "<table>";
      echo "<tr>";
      echo "  <th>Nome</th>";
      echo "  <th>Endereço</th>";
      echo "  <th>Mapa</th>";
      echo "</tr>";
      
      while($linha = $resultado->fetch_object()) {
        echo "<tr>";
        echo "  <td>$linha->nome</td>";
        echo "  <td>$linha->endereco</td>";
        echo "  <td>";
        echo "    <button type='button' Titulo='$linha->nome' Texto='$linha->endereco' lat='$linha->latitude' long='$linha->longitude' class='btn'>Ver mapa</button>";
        echo "  </td>";
        echo "</tr>";
      }
      echo "</table>";
    ?>

    <div id="mapa"></div>
  </div>
</body>
</html>
