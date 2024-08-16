<?php

//ESTE ARCHIVO SE ENCARGA DE CONSTRUIR EL DISEÑO RECIBIENDO LOS DATOS DE LA BDD

$direccionimagen = "./imagenes/otros/";


function producto($id, $icon, $nombre, $precio){ //CREA EL CUADRO DE UNIVERSIDAD
    global $direccionimagen;
    echo '<div class="universidad">';
    echo('
        <div class="icon">'.$icon.'</div>
        <h1 class="nombreuni">'.$nombre.'</h1>
        <p class="descripcionuni">Precio: $'.$precio.'</p>
        <a href="./universidad.php?universidad='.$id.'"  class="botonuni"></a>
    </div>
    ');
}
function carritoproducto($id, $icon, $nombre, $precio,$cantidad){ //CREA EL CUADRO DE UNIVERSIDAD
    global $direccionimagen;
    echo('<div class="productocarrito">
            <h1 class="nombre">'.$nombre.' x'.$cantidad.'</h1>
            <p class="precio">Precio: $'.($precio * $cantidad).'</p>
            <button href="./universidad.php?universidad='.$id.'"class="botonborrar">aaaaaaaaaaaaaaaaaaaaaaa</button>
            <div class="icono">'.$icon.'</div>
        </div>
    ');
}
function crearmapa($ubicacion){ //CREA EL MAPA CON LA UBICACION A TRAVEZ DE UNA URL MODIFICADA
    $url = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3287.4006114986105!2d-58.53745522416194!3d-34.51807695298058!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcb0946037da75%3A0x7fae4b92e6699b59!2s";
    $url2 = "!5e0!3m2!1ses-419!2sar!4v1684382444792!5m2!1ses-419!2sar";
    return $url."".urlencode($ubicacion)."".$url2;
}
function nombre_url($url){ //OBTIENE EL NOMBRE DE UNA RED SOCIAL A TRAVEZ DE SU URL
    $parsed_url = parse_url($url);

    $path = trim($parsed_url['path'], '/');

    $account_name = basename($path);
    return $account_name;
}
function generarTextoRedesSociales($contactos) { //CREA UN TEXTO COOHERENTE DONDE SE MUESTRAN TODAS LAS REDES SOCIALES DE LA UNIVERSIDAD
    global $haycorreo;

    $texto = "Contamos con ";

    $nombresRedes = [
        "youtube" => "un canal de YouTube: ",
        "instagram" => "Instagram: ",
        "whatsapp" => "Whatsapp: ",
        "tiktok" => "TikTok: ",
        "facebook" => "Facebook: ",
        "twitter" => "Twitter: ",
        "correo" => "correo electrónico: ",
        "telefono" => "numero de teléfono: ",
    ];

    $redesDisponibles = [];
    foreach ($contactos as $contacto) {
        if (isset($nombresRedes[$contacto["tipo"]])) {
            if($contacto["tipo"] == "correo"){
                $haycorreo = true;
                $redesDisponibles[] = '<span class="label">'.$nombresRedes[$contacto["tipo"]].'</span><a href="mailto:'.$contacto["contacto"].'">' .$contacto["contacto"]. '</a>';

            }else if($contacto["tipo"] == "telefono"){
                $redesDisponibles[] = '<span class="label">'.$nombresRedes[$contacto["tipo"]].'</span><a href="tel:'.arreglar_telefono($contacto["contacto"]).'">' .arreglar_telefono($contacto["contacto"]) . '</a>';
            }else{
                $redesDisponibles[] = '<span class="label">'.$nombresRedes[$contacto["tipo"]].'</span><a href="'.arreglar_url($contacto["contacto"]).'" target="_blank">' .nombre_url($contacto["contacto"]) . '</a>';
            }
        }
    }
    $cantidad = count($redesDisponibles);

    if ($cantidad == 1) {
        $texto .= $redesDisponibles[0] . ".";
    } elseif ($cantidad == 2) {
        $texto .= $redesDisponibles[0] . " y " . $redesDisponibles[1] . ".";
    } elseif ($cantidad > 2) {
        $texto .= implode(", ", array_slice($redesDisponibles, 0, -1)) . " y " . end($redesDisponibles) . ".";
    }

    return $texto;
}

function categorias($categorias){ // CREA LA LISTA DE CARRERAS Y TECNICATURAS PARA LA BARRA DE BUSQUEDA
    foreach ($categorias as $categoria) {
        echo '<option value="'.$categoria["id_categoria"].'">'.$categoria["categoria"].'</option>';
    }
}

function arreglar_telefono($tel){ // MODIFICA EL NUMERO DE TELEFONO EN CASO DE FALTAR EL +54 O EL 11
    $contidad = strlen($tel);
    if(($tel[0] != "1" && $tel[1] != "1") || ($tel[0] != "0" && $tel[1] != "1")){
        $tel = "11 ".$tel;
    }
    return $tel;
}



function arreglar_url($url){ // MODIFICA LAS URL PARA QUE FUNCIONEN CORRECTAMENTE
    if($url[0] != "h" && $url[1] != "t"){
        $posicionSlash = strpos($url, '/');
        if ($posicionSlash != false) {
            $parteAntesDelSlash = substr($url, 0, $posicionSlash);
            $parteDespuesDelSlash = substr($url, $posicionSlash);
            $url = $parteAntesDelSlash . ".com" . $parteDespuesDelSlash;
        } else {
            $url = $url . ".com";
        }
        $url = "https://www.".$url;
    }
    return $url;

}

?>

