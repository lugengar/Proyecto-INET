<?php
    include "conexionbs.php";
    $delete = isset($_GET['delete']) ? $_GET['delete'] : 0;
    $stmt = $conn->prepare("DELETE FROM producto WHERE id_producto = ?");
    $stmt->bind_param("i", $delete);

    if ($stmt->execute()) {
        echo "<p>Producto eliminado correctamente</p>";
        header("Location: ../administrar-productos.php");
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
?>