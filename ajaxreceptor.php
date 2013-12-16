<?php

include "ajaxexec.php";

/*
 * Este archivo es el que maneja las peticiones ajax
 */

class peticionAJAX {

    var $nombre;
    var $estado;

}

class respuestaAJAX {

    var $estado;
    var $errores;

}

//Obtenemos el objeto enviado
$peticion = $_POST['p'];


//Lo pasamos de JSON a Objeto de PHP
$objeto = json_decode($peticion);


//Ejecutamos la petición
$respuesta = ejecutarPeticionAJAX($objeto);

//Codificamos la respuesta
$respuesta_JSON = json_encode($respuesta);

//Y la devolvemos
echo $respuesta_JSON;

