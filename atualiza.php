<?php

   $conexao = new mysqli("localhost","root","","3binfo");

   $sql = "select situacao from recarga where id_usuario='3' order by id_recarga desc limit 1";

   $Resultado = $conexao->query($sql);
   
   $linha = $Resultado->fetch_object();

   echo $linha->situacao;
?>