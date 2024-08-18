
<?php
    include "./codigophp/conexionbs.php";
    $sql = "SELECT * FROM pedidos WHERE fk_usuario =".$_SESSION['id_usuario'];
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        foreach ($result as $index => $row) {
            echo "<div>".$row["estado"]."</div>";
        }
    } 
    $conn->close();
?>