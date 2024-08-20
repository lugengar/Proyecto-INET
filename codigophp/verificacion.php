<?php
session_start();
function esusuario($si,$no){
    if(!empty($_SESSION['id_usuario'])){
        echo $si;
    }else{
        echo $no;
    }
}
function solousuarios($url= null){
    if(empty($_SESSION['id_usuario'])){
        if($url != null){
            header("Location: ".$url."/index.php");
        }else{
            header("Location: index.php");
        }
    }
}
function soloadmin($url= null){
    if(empty($_SESSION['id_usuario'])){
        if($url != null){
            header("Location: ".$url."/index.php");
        }else{
            header("Location: index.php");
        }
        
    }else if(empty($_SESSION['jerarquia'])){
        if($url != null){
            header("Location: ".$url."/index.php");
        }else{
            header("Location: index.php");
        }
    }
    
}
function esadmin($si){
    if(!empty($_SESSION['id_usuario'])){
        if(!empty($_SESSION['jerarquia'])){
            if($_SESSION['jerarquia'] == "vendedor"){
                echo $si;
            }
        }
    }
}
?>