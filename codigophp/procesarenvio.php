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
        $sql2="SELECT * FROM pedidos WHERE id_pedido = ". $id_pedido;
        $result2 = $conn->query($sql2);
        if ($result2 && $result2->num_rows > 0) {
            foreach ($result2 as $index => $row) {
                $stmt = $conn->prepare("INSERT INTO historica (estado, fecha_entrega, productos_pedido, fk_usuario, precio_total, metodo_pago, fecha_pedido) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $row["estado"],date('Y-m-d'),$row["productos_pedidos"], $row["fk_usuario"],$row['precio_total'],$row['metodo_pagp'],$row['fecha_pedido']);
                $stmt->execute();
                $stmt->close();
                $sql3="DELETE FROM pedidos WHERE id_pedido = ". $id_pedido;
                if ($conn->query($sql3) === TRUE) {
                    echo "Pedido eliminado";
                } else {
                    echo "Error al actualizar productos: " . $conn->error;
                }  
            }
        }
        header("location: ../administrar-pedidos.php");

    }else if ($tipodeboton == "borrar"){
        $sql="DELETE FROM historica WHERE id_pedido = ". $id_pedido;
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