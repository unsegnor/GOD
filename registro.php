<?php

include "controlador.php";

$login = $_POST['login'];
$pass = $_POST['pass'];

//Comprobar que el login está libre
if(login_libre($login)){
    //Añadir el usuario y la pass
    $res = addUsuario($login, $pass);
    
    
    
    //Si todo ha ido bien -> redireccionar a la página principal
    if(!$res->hayerror){
        redirect(direcciones::index);
    }
}else{
    $res->hayerror = true;
    $res->errormsg = "El login $login ya existe.";
}

if($res->hayerror){
    $_SESSION['error'] = $res->errormsg;
    redirect(direcciones::registroWeb);
}

