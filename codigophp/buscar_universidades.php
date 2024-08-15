<?php

$result = null;
include "./codigophp/conexionbs.php";
include "./codigophp/construccion.php";
function buscarcarrera(){ //BUSCA CARRERAS/LICENCIATURAS CON EL TITULO NO TECNICO PARA MOSTRARLOS
    global $conn;
    global $stmt;
    $tec = "Técnico";
    $stmt =  $conn->prepare("SELECT * FROM carrera WHERE titulo NOT LIKE ? ");
    $param = "%$tec%";
    $stmt->bind_param("s", $param);
    $stmt->execute();
    $result = $stmt->get_result();
    carreraslista($result);
$stmt->close();

}
function buscartecnicatura(){ //BUSCA TECNICATURAS CON EL TITULO "TECNICO" PARA MOSTRARLOS
    global $conn;
    global $stmt;
    $tec = "Técnico";
    $stmt =  $conn->prepare("SELECT * FROM carrera WHERE titulo LIKE ? ");
    $param = "%$tec%";
    $stmt->bind_param("s", $param);
    $stmt->execute();
    $result = $stmt->get_result();
    carreraslista($result);
$stmt->close();

}
function buscardistritos(){ //BUSCA LOS DISTRITOS PARA MOSTRARLOS
    global $conn;
    global $stmt;
    $tec = "Técnico";
    $stmt =  $conn->prepare("SELECT * FROM distrito");
    $stmt->execute();
    $result = $stmt->get_result();
    distritolista($result);
    $stmt->close();

}
function etiqueta(){
    if (isset($_GET['busqueda']) & isset($_GET['tipo'])) {
        $busqueda = $_GET['busqueda'];
        echo '<div class="etiquetas"><a href="index.php#identificador2" id="etiqueta" class="etiqueta">Eliminar busqueda: '.$busqueda.'</a></div> <div class="barraseparadora" ></div>';
    }
}
function buscar(){ //BUSCA EN GENERAL POR LOS 4 MEDIOS DISTRITO, TECNICO,LICENCIATURA O NOMBRE
    global $conn;
    global $stmt;
    global $result;
// Validar y limpiar el parámetro de búsqueda
if (isset($_GET['busqueda']) & isset($_GET['tipo'])) {

    $busqueda = $_GET['busqueda'];
    $tipo = $_GET['tipo'];
    $param = "%$busqueda%";

    // Preparar la consulta usando una consulta preparada
    if($tipo == "nombre"){    
        $stmt = $conn->prepare("SELECT * FROM establecimiento WHERE nombre LIKE ?");
    
      

    }else if($tipo == "carrera"){ 
        $sql2 = "SELECT * FROM planestudio WHERE fk_carrera = ".$busqueda;
        $planestudio = $conn->query($sql2);
        $establecimientos= [];
        while ($row = $planestudio->fetch_assoc()) {
            array_push($establecimientos, $row["fk_establecimiento"]);
        }
        $stmt = $conn->prepare("SELECT * FROM establecimiento WHERE id_establecimiento IN (?)");
        $param =implode(", ", $establecimientos);

    }else if($tipo == "tecnicatura"){ 
        $sql2 = "SELECT * FROM planestudio WHERE fk_carrera = ".$busqueda;
        $planestudio = $conn->query($sql2);
        $establecimientos= [];
        while ($row = $planestudio->fetch_assoc()) {
            array_push($establecimientos, $row["fk_establecimiento"]);
        }
        $stmt = $conn->prepare("SELECT * FROM establecimiento WHERE id_establecimiento IN (?)");
       $param =implode(", ", $establecimientos);

    }else if($tipo == "distrito"){ 
        $stmt = $conn->prepare("SELECT * FROM establecimiento WHERE fk_distrito LIKE ?");
        

    }
    
    // Asignar parámetro y ejecutar consulta
    $stmt->bind_param("s", $param);
    $stmt->execute();

    // Obtener resultados
    $result = $stmt->get_result();
    // Añadir comodines para buscar cualquier parte de la cadena
    
   
    // Mostrar resultados (ejemplo básico)
    
}else{
    $stmt = $conn->prepare("SELECT * FROM establecimiento");
  
    $stmt->execute();

    $result = $stmt->get_result();
}
if ($result != null){
    if ($result->num_rows == 0) {
    
    echo "<p class= 'error' >No se encontraron resultados para la búsqueda: " . htmlspecialchars($busqueda)."</p>";
}else{
   
    while ($row = $result->fetch_assoc()) {
        $sql2 = "SELECT * FROM imagenes WHERE fk_establecimiento = ".$row["id_establecimiento"];
        $imagenes = $conn->query($sql2);
        universidad($row["id_establecimiento"], $row["nombre"], $row["descripcion"], $imagenes); #$row["imagenes"]);
    }
}
}else{
    echo "<p class= 'error' >No se encontraron resultados para la búsqueda: " . htmlspecialchars($busqueda)."</p>";
}

// Cerrar consulta y conexión

$stmt->close();
$conn->close();
}
?>
