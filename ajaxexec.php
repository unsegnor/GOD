<?php

include "controlador.php";


function ejecutarPeticionAJAX($objeto) {
    
    
    session_start();
    
    //Generamos el objeto de respuesta
    $respuesta = new respuestaAJAX();
    $respuesta->estado = "Procesada";

    //Aquí comprobamos el tipo de petición
    if ($objeto->nombre == "getTodosUsuarios") {

        if (tienePermiso("getUsuarios")) {

            $respuesta->resultado = getUsuarios();
        } else {
            $respuesta->error = "Sin permisos.";
        }
    }

    if ($objeto->nombre == "getUsuariosPorNombre") {

        if (tienePermiso("getUsuarios")) {

            $filtro = $objeto->filtro;
            $respuesta->resultado = getUsuariosPorNombre($filtro);
        } else {
            $respuesta->error = "Sin permisos.";
        }
    }
    
    if($objeto->nombre == "setUsuario"){
        
    }
    
    if($objeto->nombre == "nuevoUsuario"){
                
        $usuario = new Usuario();
        
        $usuario->nombre = $objeto->nombre_usuario;
        $usuario->login = $objeto->login_usuario;
        $usuario->nif_cif = $objeto->dni_usuario;
        $usuario->puesto = $objeto->puesto_usuario;
        
        $res = addUsuario($usuario);
        
        $respuesta->hayerror = $res->hayerror;
        $respuesta->errormsg = $res->errormsg;
        
    }
    
    if($objeto->nombre == "entrar"){
        
        $res = doLogin($objeto->login, $objeto->pass);
        
        if(!$res->hayerror){
            
            //Login efectuado correctamente, no hay nada más que hablar
            $respuesta->hayerror = false;
            
            
        }else{
            $respuesta->hayerror = $res->hayerror;
            $respuesta->errormsg = $res->errormsg;
        }
        
    }

    return $respuesta;
}

