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
    }
   $conn->close();

}
?>