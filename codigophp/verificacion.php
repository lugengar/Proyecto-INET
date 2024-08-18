<?php
session_start();
function esusuario($si,$no){
    if(!empty($_SESSION['id_usuario'])){
        echo $si;
    }else{
        echo $no;
    }
}
function solousuarios(){
    if(empty($_SESSION['id_usuario'])){
        header("Location: index.php");
    }
}
function soloadmin(){
    if(empty($_SESSION['id_usuario'])){
        header("Location: index.php");
        
    }else if(!empty($_SESSION['jerarquia'])){
        if($_SESSION['jerarquia'] != "vendedor"){
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