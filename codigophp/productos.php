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
    $precios = $_SESSION['pedido']['precios'];

    $tipodeboton = $_POST["enviar"];
    
    if ($tipodeboton[0] == "b" && $tipodeboton[1] == "t") {
  
        preg_match('/\d+/', $tipodeboton, $coincidencias);
        $indice = array_search((int)$coincidencias[0],$_SESSION['pedido']['productos']);

        unset($cantidad[$indice]);
        unset($id_producto[$indice]);
        unset($precios[$indice]);

        $cantidad = array_values($cantidad);
        $id_producto = array_values($id_producto);
        $precios = array_values($precios);

        $_SESSION['pedido']['productos'] = $id_producto;
        $_SESSION['pedido']['cantidad'] = $cantidad;
        $_SESSION['pedido']['precios'] = $precios;

        echo "Producto y cantidad eliminados.".$indice;
        header("location: ../index.php#carrito");
    } else if ($tipodeboton[0] == "b" && $tipodeboton[1] == "u") {
        preg_match('/\d+/', $tipodeboton, $coincidencias);
        $indice = array_search((int)$coincidencias[0],$_SESSION['pedido']['productos']);
        print_r((int)$coincidencias[0]." ".$indice);

        print_r($_SESSION['pedido']);
        $_SESSION['pedido']['cantidad'][$indice]--;

        print_r($_SESSION['pedido']['cantidad']);
        print_r($_SESSION['pedido']['productos']);

        echo "Producto y cantidad eliminados.".$indice;
        header("location: ../index.php#carrito");
    } else if ($tipodeboton == "añadir") {
        $id_producto = $_SESSION['pedido']['productos'];
        $cantidad = $_SESSION['pedido']['cantidad'];
        $precios = $_SESSION['pedido']['precios'];
    
        $nuevo_id_producto =intval( $_POST['id_producto']); 
        $nueva_cantidad = intval($_POST['cant-producto']); 
        $nuevo_precio = intval($_POST['precio']); 
    
        $indice = array_search($nuevo_id_producto,$id_producto);
    
        if ($indice !== false) {
            $cantidad[$indice] += $nueva_cantidad;
        } else {
            array_splice($id_producto,0, 0,$nuevo_id_producto);
            array_splice($cantidad, 0, 0,$nueva_cantidad);
            array_splice($precios,0, 0, $nuevo_precio);
        }
    
        $_SESSION['pedido']['productos'] = $id_producto;
        $_SESSION['pedido']['cantidad'] = $cantidad;
        $_SESSION['pedido']['precios'] = $precios;

        echo "Producto y cantidad agregados.";
        header("location: ../index.php");

    }else if ($tipodeboton == "pagar") {
      
        header("location: ../Formularios/pagar.php");
    }
   

}
?>

</body>
</html>
