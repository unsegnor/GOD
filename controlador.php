<?php

include "conexionbdd.php";

function getUsuario($login, $pass) {

    $consulta = "SELECT * FROM usuarios WHERE login ='" . escape($login) . "'";

    $res = ejecutar($consulta);

    if (!$res->hayerror) {

        //Comprobamos que sólo tengamos uno
        $resultado = $res->resultado;

        if ($resultado->num_rows == 1) {
            //Lo tenemos, lo cargamos
            $fila = $resultado->fetch_assoc();

            $usuario = new Usuario();
            $usuario->login = $fila['login'];
            $usuario->pass = $fila['pass'];
            $usuario->id = $fila['id_usuario'];

            //Comprobamos la contraseña
            $sha_pass = sha1($pass);

            if ($usuario->pass == $sha_pass) {
                //Contraseña correcta -> devolvemos el usuario
                $res->resultado = $usuario;
                
            }else{
                $res->resultado = null;
                $res->hayerror = true;
                $res->errormsg = "Contraseña incorrecta.";
            }
        }else{
            $res->resultado = null;
            $res->hayerror = true;
            $res->errormsg = "Login incorrecto";
        }
    }else{
        $res->resultado = null;
    }


    return $res;
}

function login_libre($login) {


    $consulta = "SELECT login FROM usuarios WHERE login ='" . escape($login)."'";

    $resultado = ejecutar($consulta)->resultado;

    if ($resultado->num_rows > 0) {
        $respuesta = false;
    } else {
        $respuesta = true;
    }

    return $respuesta;
}

function addUsuario($login, $pass) {
    
    $sha_pass = sha1($pass);
    
    $consulta = "INSERT INTO usuarios (login, pass) values ('".escape($login)."','".escape($sha_pass)."')";
    
    return ejecutar($consulta);
    
}

function getSituaciones(){
    
    $consulta = "SELECT * FROM situaciones, estados WHERE id_situacion = id_estado";
    
    $resultado = ejecutar($consulta)->resultado;
    
    $array = toArray($resultado);
    
    $respuesta = situacionesConvert($array);
    
    return $respuesta;
    
}

function situacionesConvert($array){
    
    $respuesta = array();
    
    foreach($array as $fila){
        
        $respuesta[] = situacionConvert($fila);
        
    }
    
    return $respuesta;
}

function situacionConvert($fila){
    
    $situacion = new Situacion();
    
    $estado = estadoFill($situacion, $fila);
    
    $situacion->problematica = $fila['problematica'];
    
    return $situacion;
    
}

function estadoFill(Estado $estado, $fila){
    $estado->id = $fila['id_estado'];
    $estado->caducidad = $fila['caducidad'];
    $estado->descripcion = $fila['descripcion'];
    $estado->entrada_en_vigor = $fila['entrada_en_vigor'];
    $estado->resumen = $fila['resumen'];
    $estado->votos_negativos = $fila['votos_negativos'];
    $estado->votos_positivos = $fila['votos_positivos'];
}

function estadoConvert($fila){
    $estado = new Estado();
    
    estadoFill($estado, $fila);
    
    return $estado;
}

function redirect($nombre_pagina) {
    header("location:$nombre_pagina");
}
