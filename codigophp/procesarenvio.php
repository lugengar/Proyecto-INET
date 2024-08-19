<?php

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
        $sql="UPDATE pedidos SET estado = 'entregado' WHERE id_pedido = ". $id_pedido;
        if ($conn->query($sql) === TRUE) {
            echo "Pedido actualizado correctamente.";
        } else {
            echo "Error al actualizar productos: " . $conn->error;
        }    
        header("location: ../administrar-pedidos.php");

    }else if ($tipodeboton == "borrar"){
        $sql="DELETE FROM pedidos WHERE id_pedido = ". $id_pedido;
        if ($conn->query($sql) === TRUE) {
            echo "Pedido eliminado";
        } else {
            echo "Error al actualizar productos: " . $conn->error;
        }  
        header("location: ../historial.php");
    }
   $conn->close();

}
?>