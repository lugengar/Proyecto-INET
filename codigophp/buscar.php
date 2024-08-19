<?php

$result = null;
include "./codigophp/conexionbs.php";
include "./codigophp/construccion.php";

function etiqueta(){
    if (isset($_GET['busqueda']) || isset($_GET['categoria'])) {
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
function productosdelcarrito(){
    global $conn;
    if (!empty($_SESSION['pedido'])) {
        if ($_SESSION['pedido']["productos"] != []) {
            $sql = "SELECT p.*, c.icon FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id_categoria WHERE p.id_producto IN (" . implode(",",$_SESSION['pedido']['productos']) . ")";
            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                foreach ($result as $index => $row) {
                    carritoproducto($index, $row["icon"],$row["nombre_producto"], $row["precio"],$_SESSION['pedido']['cantidad'][$index]);
                }
            } 
        }else {
            echo "<h1 id='nada'>NO HAY PRODUCTOS AUN</h1>";
        }
    } else {
        $_SESSION['pedido'] = ["productos" => [],"cantidad" => [],"precios" => []];
        echo "<h1 id='nada'>NO HAY PRODUCTOS AUN</h1>";
    }
}
function precio(){

    $url_actual = $_SERVER['REQUEST_URI'];

    $parsed_url = parse_url($url_actual);

    $query = isset($parsed_url['query']) ? $parsed_url['query'] : '';

    parse_str($query, $params);

    $params['precio'] = "menor";

    $nuevo_query_string = http_build_query($params);

    $nueva_url = $parsed_url['path'] . '?' . $nuevo_query_string;

    if (isset($parsed_url['fragment'])) {
        $nueva_url .= '#' . $parsed_url['fragment'];
    }
    echo '<a href="'.$nueva_url.'#identificador2">Menor precio</a>';

}
function carruselboton() {
    $url_actual = $_SERVER['REQUEST_URI'];

    $parsed_url = parse_url($url_actual);

    $query = isset($parsed_url['query']) ? $parsed_url['query'] : '';

    parse_str($query, $params);

    $params['tipo'] = 1;

    $nuevo_query_string = http_build_query($params);

    $nueva_url = $parsed_url['path'] . '?' . $nuevo_query_string;

    if (isset($parsed_url['fragment'])) {
        $nueva_url .= '#' . $parsed_url['fragment'];
    }
    echo '<a href="'.$nueva_url.'#identificador2"class="texto1" id="texto1">Ver productos relacionados con fútbol</a>';
}
function buscar(){ //BUSCA EN GENERAL POR LOS 4 MEDIOS DISTRITO, TECNICO,LICENCIATURA O NOMBRE
    global $conn;
    global $stmt;
    global $result;
// Validar y limpiar el parámetro de búsqueda
if (isset($_GET['busqueda']) && isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    $busqueda = $_GET['busqueda'];
    if ($busqueda != null && $categoria != null){
        $param = "%$busqueda%";
        $stmt = $conn->prepare("SELECT p.*, c.icon FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id_categoria WHERE p.nombre_producto LIKE ? AND p.fk_categoria = ? ORDER BY p.cantidad_vendidos DESC");

        
        $stmt->bind_param("ss", $param,$categoria);
        $stmt->execute();

        $result = $stmt->get_result();

    }else if ($categoria != null){
        $stmt = $conn->prepare("SELECT p.*, c.icon FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id_categoria WHERE p.fk_categoria = ? ORDER BY p.cantidad_vendidos DESC");
        $stmt->bind_param("s", $categoria);
        $stmt->execute();
    
        $result = $stmt->get_result();
    }else if ($busqueda != null){
        $param = "%$busqueda%";
        $stmt = $conn->prepare("SELECT p.*, c.icon FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id_categoria WHERE p.nombre_producto LIKE ? ORDER BY p.cantidad_vendidos DESC");
    
        $stmt->bind_param("s", $param);
        $stmt->execute();
    
        $result = $stmt->get_result();
    }
}else{
    $stmt = $conn->prepare("SELECT p.*, c.icon FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id_categoria ORDER BY p.cantidad_vendidos DESC");
  
    $stmt->execute();

    $result = $stmt->get_result();
}
if ($result != null){
    if ($result->num_rows == 0) {
    
    echo "<p class= 'error' >No se encontraron resultados para la búsqueda: " . htmlspecialchars($busqueda)."</p>";
}else{
    while ($row = $result->fetch_assoc()) {
        producto($row["id_producto"], $row["icon"],$row["nombre_producto"], $row["precio"], $row["cantidad_disponible"]);
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
