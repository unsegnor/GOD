<?php
include "controlador.php";

function getFormularioLogin(){
    $direccion_login = direcciones::login;
    $respuesta = " <link rel='stylesheet' type='text/css' href='media/css/login.css'>
             <form id='login_form' action=\"$direccion_login\" method=\"post\">
             <input type='text' name='login' id='login' placeholder='Usuario'>
             <input type='password' id='pass' name='pass' placeholder='*********'>
             <input type='submit' name='submit' value='Acceder'>
             </form>      
";
    
    return $respuesta;
}

function getFormularioRegistro(){
    $direccion_registro = direcciones::registro;
    $respuesta = " <link rel='stylesheet' type='text/css' href='media/css/login.css'>
             <form id='login_form' action=\"$direccion_registro\" method=\"post\">
             <input type='text' name='login' id='login' placeholder='Usuario'>
             <input type='password' id='pass' name='pass' placeholder='*********'>
             <input type='submit' name='submit' value='Soy Nuevo'>
             </form>      
";
    
    return $respuesta;
}


function getMenu(){ //TODO la id de usuario la usaremos para determinar los permisos
    
    $respuesta="";
    
    
    //Mostramos el nombre del usuario
    $nombre_usuario = $_SESSION['login'];
    $respuesta.= "<strong>$nombre_usuario</strong>";
    $respuesta.= linkTo("Desconectarse", direcciones::logout);
    
    
    
    return $respuesta;
}


function linkTo($texto, $pagina){
    return "<a href=\"$pagina\">$texto</a>";
}

function listadoSituaciones(){
    
    $situaciones = getSituaciones();
    
    
    
    $respuesta = "<ul>";
    
    foreach($situaciones as $situacion){
        
        $respuesta .= "<li>$situacion->resumen</li>";
        
    }
    
    $respuesta .= "</ul>";
    
    return $respuesta;
}
