<?php

$result = null;
include "./codigophp/conexionbs.php";
include "./codigophp/construccion.php";

function etiqueta(){
    if (isset($_GET['busqueda']) || isset($_GET['tipo'])) {
        $busqueda = $_GET['busqueda'];
        echo '<div class="etiquetas"><a href="index.php#identificador2" id="etiqueta" class="etiqueta">Eliminar filtros</a></div> <div class="barraseparadora" ></div>';
    }else{
        echo '<div class="barraseparadora" ></div>';
    }
}
function crearcategorias(){
    global $conn;

    $sql2 = "SELECT * FROM categoria";
    $categorias = $conn->query($sql2);
    categorias($categorias);

}
function buscar(){ //BUSCA EN GENERAL POR LOS 4 MEDIOS DISTRITO, TECNICO,LICENCIATURA O NOMBRE
    global $conn;
    global $stmt;
    global $result;
// Validar y limpiar el parámetro de búsqueda
if (isset($_GET['busqueda']) && isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    $busqueda = $_GET['busqueda'];
    if ($busqueda != null && $tipo != null){
        $param = "%$busqueda%";
        $stmt = $conn->prepare("SELECT p.*, c.icon FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id_categoria WHERE p.nombre_producto LIKE ? AND p.fk_categoria = ?");

        
        $stmt->bind_param("ss", $param,$tipo);
        $stmt->execute();

        $result = $stmt->get_result();
    }else if ($tipo != null){
        $stmt = $conn->prepare("SELECT p.*, c.icon FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id_categoria WHERE p.fk_categoria = ?");
        $stmt->bind_param("s", $tipo);
        $stmt->execute();
    
        $result = $stmt->get_result();
    }else if ($busqueda != null){
        $param = "%$busqueda%";
        $stmt = $conn->prepare("SELECT p.*, c.icon FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id_categoria WHERE p.nombre_producto LIKE ?");
    
        $stmt->bind_param("s", $param);
        $stmt->execute();
    
        $result = $stmt->get_result();
    }
}else{
    $stmt = $conn->prepare("SELECT p.*, c.icon FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id_categoria");
  
    $stmt->execute();

    $result = $stmt->get_result();
}
if ($result != null){
    if ($result->num_rows == 0) {
    
    echo "<p class= 'error' >No se encontraron resultados para la búsqueda: " . htmlspecialchars($busqueda)."</p>";
}else{
    while ($row = $result->fetch_assoc()) {
        producto($row["id_producto"], $row["icon"],$row["nombre_producto"], $row["precio"], null);
    }
   /*
    while ($row = $result->fetch_assoc()) {
        $sql2 = "SELECT * FROM imagenes WHERE fk_establecimiento = ".$row["id_establecimiento"];
        $imagenes = $conn->query($sql2);
        universidad($row["id_establecimiento"], $row["nombre"], $row["descripcion"], $imagenes); #$row["imagenes"]);
    }*/
}
}else{
    echo "<p class= 'error' >No se encontraron resultados para la búsqueda: " . htmlspecialchars($busqueda)."</p>";
}

// Cerrar consulta y conexión

$stmt->close();
$conn->close();
}
?>
