<?php
  // Se recibe el ID del usuario eliminar a traves de POST
  $idusuario = $_POST["idusuario"];

  $servername = "127.0.0.1"; // Ubicacion del servidor (host)
  $username = "php"; // usuario de la base de datos (cambiar por el correspondiente a utilizar , normalmente root)
  $password = "123456"; // contraseña del usuario especificado
  $database = "abmphp"; // base de datos a utilizar

  // Crear conexión
  $con = mysqli_connect($servername, $username, $password, $database);
  mysqli_set_charset($con,"utf8"); //Establecer el set de caracteres a UTF-8 para que soporte acentos y ñ

  // Comprobar si la conexión se realizó correctamente
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
  // Sentencia SQL para eliminar el registro segun el ID recibido
  $sql = "DELETE FROM usuario WHERE idusuario = $idusuario";
 ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    //Se ejecuta la sentencia
    if (mysqli_query($con, $sql)):
      echo "<div>Eliminado correctamente!</div>";
    else:
      echo "<div>Error al eliminar: " . $sql . "<br>" . mysqli_error($con)."</div>";
    endif;
     ?>
     <a href="index.php">Lista de usuarios</a>
  </body>
</html>
