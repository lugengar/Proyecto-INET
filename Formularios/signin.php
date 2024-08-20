<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="../estiloscss/formularios.css">

</head>
<div id="textura"></div>

<body>
<div class="fondo">
<div class="logocarrusel"></div>
<a class="logocarrusel2" href="../index.php"></a>
<form class="signin" action="" method="POST">
    <h2>Formulario de Registro</h2>
    <div class="inputs2">
        <input type="email" name="correo" placeholder="Ingrese un correo" required>
        <input type="password" name="contrasenia" placeholder="Ingrese una contraseña" required>
    </div>
    <?php include("v_signin.php"); ?>
    <p class="p">¿Aún no tenes una cuenta? <a href="signup.php">Registrate</a></p>
    <input type="submit" value="Inicia sesión" class="btn">
</form>
</div>
</body>