<?php
        use MercadoPago\Client\Payment\PaymentClient;
        use MercadoPago\MercadoPagoConfig;
        use MercadoPago\Client\Common\RequestOptions;    
        use MercadoPago\Exceptions\MPApiException;
function dividirTexto($texto) {
    if (strpos($texto, ',') !== false) {
        $partes = explode(",", $texto);

        $parte1 = trim($partes[0]);
        $parte2 = trim($partes[1]);

        return [$parte1, $parte2];
    } else {
        return [$texto, 'no tiene'];
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
include "./conexionbs.php";

    $tipodeboton = $_POST["envio"];
    $id_pedido = $_POST["id_pedido"];
    
    if ($tipodeboton == "enviar") {
        $sql="UPDATE pedidos SET estado = 'en camino' WHERE id_pedido = ". $id_pedido;
        if ($conn->query($sql) === TRUE) {
            echo "Pedido actualizado correctamente.";
        } else {
            echo "Error al actualizar productos: " . $conn->error;
        }    
        header("location: ../administrar-pedidos.php");

    }else if ($tipodeboton == "entregado") {
        $sql2 = "SELECT * FROM pedidos WHERE id_pedido = ". $id_pedido;
        $result2 = $conn->query($sql2);
        
        if ($result2 && $result2->num_rows > 0) {
            foreach ($result2 as $index => $row) {
                // Define variables para los valores literales
                $estado = "entregado";
                $fecha_entrega = date('Y-m-d');
                $productos_pedido = $row["productos_pedido"];
                $fk_usuario = $row["fk_usuario"];
                $precio_total = $row['precio_total'];
                $metodo_pago = $row['metodo_pago']; // Corrige aquí el typo de "metodo_pagp" si es necesario
                $fecha_pedido = $row['fecha_pedido'];
        
                // Prepara y ejecuta la consulta
                $stmt = $conn->prepare("INSERT INTO historica (estado, fecha_entrega, productos_pedido, fk_usuario, precio_total, metodo_pago, fecha_pedido) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $estado, $fecha_entrega, $productos_pedido, $fk_usuario, $precio_total, $metodo_pago, $fecha_pedido);
                $stmt->execute();
                $stmt->close();
        
                // Elimina el pedido original
                $sql3 = "DELETE FROM pedidos WHERE id_pedido = ". $id_pedido;
                if ($conn->query($sql3) === TRUE) {
                    echo "Pedido eliminado";
                } else {
                    echo "Error al actualizar productos: " . $conn->error;
                }  
            }
        }
        
        header("location: ../administrar-pedidos.php");
        
    }else if ($tipodeboton == "borrar"){
        $sql="DELETE FROM historica WHERE id_historica = ". $id_pedido;
        if ($conn->query($sql) === TRUE) {
            echo "Pedido eliminado";
        } else {
            echo "Error al actualizar productos: " . $conn->error;
        }  
        header("location: ../historial.php");
    }else if ($tipodeboton == "cancelar"){
        $sql2 = "SELECT * FROM pedidos WHERE id_pedido = ". $id_pedido;
        $result2 = $conn->query($sql2);

        
        require '../vendor/autoload.php';

        MercadoPagoConfig::setAccessToken("APP_USR-7854084530284610-081814-ef64e9962983f3b48c4cdc11a75632d7-1950389309");
       
        if ($result2 && $result2->num_rows > 0) {
            foreach ($result2 as $index => $row) {
                $estado = "cancelado";
                $fecha_entrega = null;
                $productos_pedido = $row["productos_pedido"];
                $fk_usuario = $row["fk_usuario"];
                $precio_total = $row['precio_total'];
                $metodo_pago = $row['metodo_pago']; 
                $fecha_pedido = $row['fecha_pedido'];
                $payment_id = dividirTexto($metodo_pago)[1];

                $client = new PaymentClient();
                $request_options = new RequestOptions();
                $request_options->setCustomHeaders(["X-Idempotency-Key: 77e1c83b-7bb0-437b-bc50-a7a58e5660ac"]);
                $payment = $client->cancel($payment_id, $request_options);
                echo $payment->status;

                /*$stmt = $conn->prepare("INSERT INTO historica (estado, fecha_entrega, productos_pedido, fk_usuario, precio_total, metodo_pago, fecha_pedido) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $estado, $fecha_entrega, $productos_pedido, $fk_usuario, $precio_total, $metodo_pago, $fecha_pedido);
                $stmt->execute();
                $stmt->close();
        
                $sql3 = "DELETE FROM pedidos WHERE id_pedido = ". $id_pedido;
                if ($conn->query($sql3) === TRUE) {
                    echo "Pedido eliminado";
                } else {
                    echo "Error al actualizar productos: " . $conn->error;
                }  */
            }
        }
       
            
     
            header("location: ../historial.php");
    }
   $conn->close();

}
?>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
