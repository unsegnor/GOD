<?php

include "controlador.php";

$login = $_POST['login'];
$pass = $_POST['pass'];

//Comprobar login y pass
$res = getUsuario($login, $pass);

if (!$res->hayerror) {

    $usuario_encontrado = $res->resultado;

    if ($usuario_encontrado) {
        //Rellenamos la sesión y redireccionamos a la página inicial
        $_SESSION['loged_in'] = true;
        $_SESSION['login'] = $usuario_encontrado->login;
        $_SESSION['id_usuario'] = $usuario_encontrado->id;

        redirect(direcciones::pagina_inicial);
    }
}else{

//Si llegamos hasta aquí es que algo ha fallado
redirect(direcciones::index);

$_SESSION['errores'] = "Login ha fallado.".$res->errormsg;

//El error está en $res->errormsg

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
