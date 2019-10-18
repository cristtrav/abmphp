<?php
  // Se capturan los datos del formulario a recibidos por POST
  $idusuario = $_POST["idusuario"];
  $nombres = $_POST["nombres"];
  $apellidos = $_POST["apellidos"];
  $email = $_POST["email"];
  $pwd = $_POST["pwd"];
  $confpwd = $_POST["confpwd"];

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
 ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      //Validaciion de campos
      if(empty($nombres)){
        echo "<div>Complete el campo 'Nombres'</div>";
        $formularioValidado = false;
      }else if(empty($apellidos)){
        echo "<div>Complete el campo 'Apellidos'</div>";
        $formularioValidado = false;
      }else if(empty($email)){
        echo "<div>Complete el campo 'Email'</div>";
        $formularioValidado = false;
      }else{
        // Se pregunta si el idusuario esta en blando. Esto indica una operacion CREAR. Se exige ingresar una contraseña.
        if(empty($idusuario)){
          if(empty($pwd)){
            echo "<div>Ingrese una contraseña</div>";
            $formularioValidado = false;
          }else if($pwd != $confpwd){
            echo "<div>Las contraseñas no coinciden</div>";
            $formularioValidado = false;
          }else{
            $formularioValidado = true;
          }
        // Si existe el idusuario indica una operacion EDITAR. Si el campo contraseña se recibe en blanco esto indica que se mantiene la contraseña vieja.
        }else{
          //Si ambos campos de contraseña estan en blanco se hace pasar por valido
          if(empty($pwd) && empty($confpwd)){
            $formularioValidado = true;
          }else if($pwd != $confpwd){
            echo "<div>Las contraseñas no coinciden</div>";
            $formularioValidado = false;
          }else{
            $formularioValidado = true;
          }
        }

      }
      // Se toma una decision en base a la bandera de validacion.
      if(!$formularioValidado): ?>
      <div>
        <!-- se muestra un enlace para volver a intentar la carga de los datos segun el registro a editar -->
          <a href="formulario.php<?= !empty($idusuario)?"?idusuario=".$idusuario : "" ?>">Volver a intentar</a>
      </div>

    <?php else:
      // Se escapan los datos recibidos para evitar Inyeccion SQL
      $nombresEscaped = mysqli_real_escape_string($con, $nombres);
      $apellidosEscaped = mysqli_real_escape_string($con, $apellidos);
      $emailEscaped = mysqli_real_escape_string($con, $email);
      $pwdEscaped = mysqli_real_escape_string($con, $pwd);
      // Se consulta el valor de idusuario. Si se encuentra en blanco indica que se va a CREAR un nuevo registro.
      if(empty($idusuario)){
        $sql = "INSERT INTO usuario (nombres, apellidos, email, password) VALUES ('$nombresEscaped', '$apellidosEscaped', '$emailEscaped', SHA2('$pwdEscaped', 256))";
      }else {
        // Si idusuario contiene un valor indica operacion EDITAR. El valor se usa como parametro en las consultas.
        if(empty($pwd)){
          //Si no se ingresa una contraseña se mantendrá la antigua
          $sql = "UPDATE usuario SET nombres = '$nombresEscaped', apellidos = '$apellidosEscaped', email = '$emailEscaped' WHERE idusuario = $idusuario";
        }else{
          //Se actualizan todos los datos
          $sql = "UPDATE usuario SET nombres = '$nombresEscaped', apellidos = '$apellidosEscaped', email = '$emailEscaped', password = SHA2('$pwdEscaped', 256) WHERE idusuario = $idusuario";
        }
      }

    if (mysqli_query($con, $sql)): // Se ejecuta la sentencia SQL. INSERT o UPDATE segun lo calculado antes.
      echo "<div>Guardado correctamente!</div>";
    else:
      echo "<div>Error: " . $sql . "<br>" . mysqli_error($con)."</div>";
    endif; ?>
    <div>
      <a href="index.php">Lista de usuarios</a>
    </div>
     <?php endif; ?>
  </body>
</html>
