<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
       if(isset($_POST["nome"]))
        {
            echo $_POST["nome"];
        } 
    ?>
    <form action="teste.php" method="post">

      <input type="text" name="nome">

      <input type="submit" value="OK">
    </form>
</body>
</html>