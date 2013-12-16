<?php

class direcciones{
    const pagina_inicial = "index.php";
    const login = "login.php";
    const index = "index.php";
    const logout = "logout.php";
    const gestion_usuarios = "usuarios.php";
    const registro = "registro.php";
    const registroWeb = "registroweb.php";
}

class Res{
    var $resultado;
    var $hayerror = false;
    var $errormsg;
}

class Usuario{
    var $id;
    var $login;
    var $pass;
}

class Estado{
    var $id;
    var $resumen;
    var $descripcion;
    var $votos_positivos;
    var $votos_negativos;
    var $entrada_en_vigor;
    var $caducidad;
}

class Situacion extends Estado{
    var $problematica;
}