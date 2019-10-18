
<?php
  // Se recibe el id de usuario a elimnar a traves de un parametro de URL
  $idusuario = isset($_GET["idusuario"])?$_GET["idusuario"]:"";
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
      <div>
        ¿Realmente desea eliminar el usuario?
      </div>
      <form method="post" action="eliminar.php">
        <input type="hidden" name="idusuario" value="<?= $idusuario ?>">
        <!-- En caso de que se elija la opcion eliminar se envia un post con el ID al archivo eliminar.php -->
        <a href="index.php">CANCELAR</a><input type="submit" value="Eliminar">
      </form>
  </body>
</html>
