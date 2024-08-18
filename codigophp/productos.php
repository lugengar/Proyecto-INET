<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_SESSION['pedido']['productos'];
    $cantidad = $_SESSION['pedido']['cantidad'];

    $tipodeboton = $_POST["enviar"];
    
    if ($tipodeboton[0] == "b" && $tipodeboton[1] == "t") {
        $indice = intval($tipodeboton[2]);

        unset($cantidad[$indice]);
        unset($id_producto[$indice]);

        $cantidad = array_values($cantidad);
        $id_producto = array_values($id_producto);

        $_SESSION['pedido']['productos'] = $id_producto;
        $_SESSION['pedido']['cantidad'] = $cantidad;

        echo "Producto y cantidad eliminados.".$indice;
        header("location: ../index.php#carrito");
    } elseif ($tipodeboton[0] == "b" && $tipodeboton[1] == "u") {
        $indice = intval($tipodeboton[2]);
        $_SESSION['pedido']['cantidad'][$indice]--;
        echo "Cantidad disminuida.".$indice;
        header("location: ../index.php#carrito");
    } elseif ($tipodeboton == "añadir") {
        $nuevo_id_producto = $_POST['id_producto']; 
        $nueva_cantidad = intval($_POST['cantidad']); 
    
        $indice = array_search($nuevo_id_producto, $id_producto);
    
        if ($indice !== false) {
            $cantidad[$indice] += $nueva_cantidad;
        } else {
            $id_producto[] = $nuevo_id_producto;
            $cantidad[] = $nueva_cantidad;
        }
    
        $_SESSION['pedido']['productos'] = $id_producto;
        $_SESSION['pedido']['cantidad'] = $cantidad;
        echo "Producto y cantidad agregados.";
        header("location: ../index.php");

    }
   

}
?>

</body>
</html>
