<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "abc";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener datos del formulario
    $tabla = $_POST['tabla'];

    // Función para comprobar duplicados
    function checkDuplicate($conn, $table, $column, $value) {
        $query = "SELECT COUNT(*) as count FROM $table WHERE $column = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    $executeStmt = true;

    if ($tabla === "carrera") {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $titulo = $_POST['titulo'];

        if (!checkDuplicate($conn, 'carrera', 'nombre', $nombre)) {
            $stmt = $conn->prepare("INSERT INTO carrera (nombre, descripcion, titulo) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $descripcion, $titulo);
        } else {
            echo "Entrada duplicada para carrera: $nombre";
            $executeStmt = false;
        }

    } elseif ($tabla === "contacto") {
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['tipo'];
        $contacto = $_POST['contacto'];
        $fk_establecimiento = $_POST['fk_establecimiento'];

        if (!checkDuplicate($conn, 'contacto', 'fk_establecimiento', $fk_establecimiento)) {
            $stmt = $conn->prepare("INSERT INTO contacto (descripcion, tipo, contacto, fk_establecimiento) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $descripcion, $categoria, $contacto, $fk_establecimiento);
        } else {
            echo "Entrada duplicada para contacto con fk_establecimiento: $fk_establecimiento";
            $executeStmt = false;
        }

    } elseif ($tabla === "distrito") {
        $nombre = $_POST['nombre'];

        if (!checkDuplicate($conn, 'distrito', 'nombre', $nombre)) {
            $stmt = $conn->prepare("INSERT INTO distrito (nombre) VALUES (?)");
            $stmt->bind_param("s", $nombre);
        } else {
            echo "Entrada duplicada para distrito: $nombre";
            $executeStmt = false;
        }

    } elseif ($tabla === "establecimiento") {
        $nombre = $_POST['nombre'];
        $ubicacion = $_POST['ubicacion'];
        $descripcion = $_POST['descripcion'];
        $categoria_establecimiento = $_POST['tipo_establecimiento'];
        $servicios = $_POST['servicios'];
        $fk_distrito = $_POST['fk_distrito'];

        if (!checkDuplicate($conn, 'establecimiento', 'nombre', $nombre)) {
            $stmt = $conn->prepare("INSERT INTO establecimiento (nombre, ubicacion, descripcion, tipo_establecimiento, servicios, fk_distrito) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $nombre, $ubicacion, $descripcion, $categoria_establecimiento, $servicios, $fk_distrito);
        } else {
            echo "Entrada duplicada para establecimiento: $nombre";
            $executeStmt = false;
        }

    } elseif ($tabla === "imagenes") {
        $url = $_POST['url'];
        $fk_establecimiento = $_POST['fk_establecimiento'];

        if (!checkDuplicate($conn, 'imagenes', 'fk_establecimiento', $fk_establecimiento)) {
            $stmt = $conn->prepare("INSERT INTO imagenes (url, fk_establecimiento) VALUES (?, ?)");
            $stmt->bind_param("si", $url, $fk_establecimiento);
        } else {
            echo "Entrada duplicada para imágenes con fk_establecimiento: $fk_establecimiento";
            $executeStmt = false;
        }

    } elseif ($tabla === "planestudio") {
        $pdf = $_POST['pdf'];
        $fk_carrera = $_POST['fk_carrera'];
        $fk_establecimiento = $_POST['fk_establecimiento'];

        if (!checkDuplicate($conn, 'planestudio', 'fk_establecimiento', $fk_establecimiento)) {
            $stmt = $conn->prepare("INSERT INTO planestudio (pdf, fk_carrera, fk_establecimiento) VALUES (?, ?, ?)");
            $stmt->bind_param("sii", $pdf, $fk_carrera, $fk_establecimiento);
        } else {
            echo "Entrada duplicada para plan de estudio con fk_establecimiento: $fk_establecimiento";
            $executeStmt = false;
        }
    }

    if ($executeStmt && isset($stmt) && $stmt->execute()) {
        echo "Nuevo registro creado exitosamente";
    } else {
        echo "Error: " . ($stmt ? $stmt->error : $conn->error);
    }

    // Cerrar conexión
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
?>
