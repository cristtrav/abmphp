<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      // Establecer los parametros de conexion en variables
      $servername = "127.0.0.1"; // Ubicacion del servidor (host)
      $username = "php"; // usuario de la base de datos (cambiar por el correspondiente a utilizar , normalmente root)
      $password = "123456"; // contraseña del usuario especificado
      $database = "abmphp"; // base de datos a utilizar

      // Crear conexión
      $con = mysqli_connect($servername, $username, $password, $database);

      // Comprobar si la conexión se realizó correctamente
      if (!$con) {
        die("Fallo al conectar a base de datos: " . mysqli_connect_error());
      }

      mysqli_set_charset($con, "utf8"); //Establecer el set de caracteres a UTF-8 para que soporte acentos y ñ

      // Crear la consulta SQL
      $sql = "SELECT * from usuario";
      // Ejecutar la consulta y almacenar el resultado
      $resultado = mysqli_query($con, $sql);
     ?>
     <a href="formulario.php?op=c">Agregar</a>
     <table border="1">
       <thead>
         <tr>
           <th>Código</th>
           <th>Nombres</th>
           <th>Apellidos</th>
           <th>Email</th>
           <th>Acciones</th>
         </tr>
       </thead>
       <tbody>
         <?php
         // Preguntar si existen registros
         if(mysqli_num_rows($resultado) > 0):
           //Recorrer el arreglo de resultados
           while($fila = mysqli_fetch_assoc($resultado)): ?>
          <tr>
            <td><?= $fila["idusuario"] ?></td>
            <td><?= $fila["nombres"] ?></td>
            <td><?= $fila["apellidos"] ?></td>
            <td><?= $fila["email"] ?></td>
            <td>
              <!-- Links se pasa a traves del parametro de URL el id de usuario a modificar -->
              <a href="formulario.php?idusuario=<?= $fila["idusuario"] ?>">Editar</a>
              <!-- Links se pasa a traves del parametro de URL el id de usuario a eliminar -->
              <a href="confirmareliminacion.php?idusuario=<?= $fila["idusuario"] ?>">Eliminar</a>
            </td>
          </tr>
         <?php endwhile;
              // Si no existen registros se informa
              else: ?>
            <tr>
              <td colspan="5">(Sin registros)</td>
            </tr>
         <?php endif; ?>
       </tbody>
     </table>
  </body>
</html>
