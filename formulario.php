<?php
// Recibir y comprobar si se va a EDITAR o CREAR segun el idusuario. Si este esta en blanco significa que se va a CREAR sino se va a EDITAR
$idusuario = isset($_GET["idusuario"])?$_GET["idusuario"]:'';
//Si existe un idusuario se obtiene sus datos y se acargan el el formulario
  if(!empty($idusuario)){
  // Establecer los parametros de conexion en variables
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
  // Consulta para traer los datos del usuario a partir del idusuario proporcionado
  $sql = "SELECT * FROM usuario WHERE idusuario = $idusuario";
  $resultado = mysqli_query($con, $sql);
  if(mysqli_num_rows($resultado) > 0){
    $fila = mysqli_fetch_assoc($resultado);
  }
}
 ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <!-- En cada INPUT se realiza una pregunta de una sola linea para definir si se va a cargar datos desde la base de datos o no -->
    <form method="post" action="procesarformulario.php">
      <!-- Input de tipo oculto (HIDDEN) que se pasara al procesar para determinar que registro editar de ser el caso -->
      <input type="hidden" name="idusuario" value="<?= $idusuario ?>" />
      <label for="nombres">Nombres</label><br />
      <input id="nombres" name="nombres" type="text" placeholder="Ej.: Juan" value="<?= isset($fila)?$fila["nombres"]:"" ?>" /><br />
      <label for="apellidos">Apellidos</label><br />
      <input id="apellidos" name="apellidos" type="text" placeholder="Ej.: Perez" value="<?= isset($fila)?$fila["apellidos"]:"" ?>" /><br />
      <label for="email">Email</label><br />
      <input id="email" name="email" type="text" placeholder="Ej.: juanperez@mail.com" value="<?= isset($fila)?$fila["email"]:"" ?>" /><br />
      <label for="pwd">Contraseña</label><br />
      <input id="pwd" name="pwd" type="password" /><br />
      <label for="confpwd">Confirmar Contraseña</label><br />
      <input id="confpwd" name="confpwd" type="password" /><br />
      <input type="submit" value="Guardar" />
    </form>
  </body>
</html>
