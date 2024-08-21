<?php
include "../codigophp/verificacion.php";
solousuarios("..");  

include "../codigophp/conexionbs.php";

    use MercadoPago\Client\Preference\PreferenceClient;
    use MercadoPago\MercadoPagoConfig;
    require '../vendor/autoload.php';
    MercadoPagoConfig::setAccessToken("APP_USR-7854084530284610-081814-ef64e9962983f3b48c4cdc11a75632d7-1950389309");

    $client = new PreferenceClient();
    
    $backUrls = [
        "success" => "https://lugengar.github.io/Proyecto-INET/bypass/index.html"
    ];
    $items = [];
    $total=0;
    $sql = "SELECT* FROM producto WHERE id_producto IN (" . implode(",",$_SESSION['pedido']['productos']) . ")";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        foreach ($result as $index => $row) {
            $items[] = [
                "id" => intval($row['id_producto']),
                "title" => $row["nombre_producto"],
                "description" => $row["descripcion"],
                "quantity" => intval($_SESSION['pedido']['cantidad'][$index]),
                "unit_price" => 1,//floatval($row["precio"]),
            ];
            $total = $total + (floatval($row["precio"]) * intval($_SESSION['pedido']['cantidad'][$index]));
        }
    } 
  
    $_SESSION['total'] = $total;
    $conn->close();
    $preference = $client->create([
        "items" => $items,
        "back_urls" => $backUrls,
        "auto_return" => "approved",
        "statement_descriptor" => "PODIUM", 
        "external_reference" => "",
        //"notification_url" => "http://localhost/Proyecto-INET/Formularios/crearpedido.php"

    ]);
    ?>

    <script src="https://sdk.mercadopago.com/js/v2"></script>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de pago</title>
    <link rel="stylesheet" href="../estiloscss/formularios.css">

</head>
<div id="textura"></div>

<body>
<div class="fondo">
<div class="logocarrusel"></div>
<a class="logocarrusel2" href="../index.php"></a>
<form class="signin">
    <h2>Formulario de Pago</h2>
    <div class="inputs2">
        <input type="text" placeholder=" <?php  echo "Total a pagar: $".$total; ?> " readonly>
        <?php  
         if ($result->num_rows > 0) {
            foreach ($result as $index => $row) {
                echo '<input type="text" placeholder="'.$row["nombre_producto"].' x'.intval($_SESSION['pedido']['cantidad'][$index]).' - $'.(floatval($row["precio"]) * intval($_SESSION['pedido']['cantidad'][$index])).'" readonly>';
            }
        } 
        ?>
    </div>
    <p class="p">¿Te falto algun articulo? <a href="../index.php">Volver atras</a></p>

    <div class="btn" style="background-color: transparent;" id="wallet_container"></div>
</form>
</div>
</body>
<script>
const mp = new MercadoPago('APP_USR-73e6ac01-337e-4425-ad81-c97a449906f3', {locale: "es-AR"});
mp.bricks().create("wallet", "wallet_container", {
   initialization: {
       preferenceId: '<?php echo $preference->id; ?>',
       redirectMode: "modal",
   },
customization: {
 texts: {
    action: "buy",
  valueProp: 'security_safety',
 },
 },
});



</script>