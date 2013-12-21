<?php

include "controlador.php";


function ejecutarPeticionAJAX($objeto) {
    
    
    //session_start();
    
    //Generamos el objeto de respuesta
    $respuesta = new respuestaAJAX();
    $respuesta->estado = "Procesada";

    //Aquí comprobamos el tipo de petición
    if ($objeto->nombre == "votaEsatado") {

    }

    

    return $respuesta;
}

