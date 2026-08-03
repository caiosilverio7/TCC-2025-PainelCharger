<?php

   $conexao = new mysqli("localhost","root","Lamm$2020","3BInfo");

   $sql = "select situacao from recarga where id_esp='1'";

   $Resultado = $conexao->query($sql);
   
   $linha = $Resultado->fetch_object();

   echo $linha->situacao;
?>

   