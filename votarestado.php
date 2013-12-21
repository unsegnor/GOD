<?php

include "controlador.php";
//recuperamos los parámetros que nos pasan

$id_estado = $_REQUEST['id'];
$tipo = $_REQUEST['tipo'];


//Anotamos el voto si estamos logueados claro
if(isset($_SESSION['loged_in'])){
    $id_usuario = $_SESSION['id_usuario'];
    
    //Votamos
    $res = addVotoEstado($id_usuario, $id_estado, $tipo);
    
    if(!$res->hayerror){
        redirect(direcciones::index);
    }
    
}

 
