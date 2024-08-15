<?php
// OBTIENE EL PLAN DE ESTUDIOS DE LA CARRERA
$result = null;
include "./codigophp/conexionbs.php";

// Validar y limpiar el parámetro de búsqueda
if (isset($_GET['carrera'])) {

    $busqueda = $_GET['carrera'];

    // Preparar la consulta usando una consulta preparada
    $stmt = $conn->prepare("SELECT * FROM planestudio WHERE fk_carrera = ?");
    
    $stmt->bind_param("s", $busqueda);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
    
        echo "<p class= 'error' >No se encontraron resultados para la búsqueda: " . htmlspecialchars($busqueda)."</p>";
    }else{
        
        $sql2 = "SELECT * FROM carrera WHERE id_carrera = ".$busqueda;
        $titulo = $conn->query($sql2);
        $row2 = $titulo->fetch_assoc();
       
        info_carrera($row2["titulo"],$row2["descripcion"],$result,null);
    }
    $stmt->close();
    $conn->close();
}


?>
