<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="css/estilos.css">

</head>
<body>

<form action="" method="POST">
    <h2>Formulario de Registro</h2>
    <div class="inputs">
        <input type="text" name="nombre" placeholder="Ingrese su nombre" required>  
        <input type="text" name="apellido" placeholder="Ingrese su apellido" required>
        <input type="password" name="contrasenia" placeholder="Ingrese una contraseña" required>
        <input type="password" name="confirmar_contrasenia" placeholder="Verifique la contraseña" required>
        <input type="email" name="correo" placeholder="Ingrese un correo" required>
        <input type="text" name="direccion" placeholder="Ingrese su dirección" required>
    </div>
    <?php include("v_signup.php"); ?>
    <p class="p">¿Ya tenes una cuenta? <a href="signin.php">Inicia sesión</a></p>
    <input type="submit" value="Registrar" class="btn">
</form>