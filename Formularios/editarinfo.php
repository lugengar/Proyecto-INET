<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de información</title>
    <link rel="stylesheet" href="../estiloscss/formularios.css">

</head>
<div id="textura"></div>
<?php

session_start();

?>
<body>
<div class="fondo">
<div class="logocarrusel"></div>
<a class="logocarrusel2" href="../index.php"></a>
<form class="signin" action="./v_editarinfo.php" method="POST">
    <h2>Edición de información </h2>
    <div class="inputs2">
        <input type="text" name="nombre" placeholder="Nombre: <?php echo $_SESSION["nombre"]; ?>" required>
        <input type="text" name="apellido" placeholder="Apellido: <?php echo $_SESSION["apellido"]; ?>" required>
        <input type="text" name="direccion" placeholder="Dirección: <?php echo $_SESSION["direccion"]; ?>" required>
    </div>
    <input type="submit" value="Editar información " class="btn">
</form>
</div>
</body>