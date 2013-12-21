<?php

include "controlador.php";

function getFormularioLogin() {
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

function usingAJAX() {

    return "<script type=\"text/javascript\" src=\"ajax.js\"/>";
}

function getAddSituacionForm() {

    include "addsituacionform.html";
}

function getTablaEstados() {

    //Devuelve una tabla con el listado de situaciones y el de propuestas

    $respuesta = "<table>";
    $respuesta.= "<tr><th>Situaciones</th><th>Objetivos</th><tr>";

    $respuesta .= "<tr><td>" . listadoSituaciones() . "</td><td>" . listadoObjetivos() . "</td></tr>";

    $respuesta .= "</table>";

    return $respuesta;
}

function getFormularioRegistro() {
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

function getBotonesVoto($id_estado) {

    return "<table border='1'><tr>"
            . "<td><a href=votarestado.php?tipo=1&id=$id_estado>Me gusta</a></td>"
            . "<td><a href=votarestado.php?tipo=-1&id=$id_estado>No me gusta</a></td>"
            . "</tr></table>";
}

function getMenu() { //TODO la id de usuario la usaremos para determinar los permisos
    $respuesta = "<table border='1'><tr>";


    //Mostramos el nombre del usuario
    $nombre_usuario = $_SESSION['login'];
    $respuesta.= "<td><strong>$nombre_usuario</strong></td>";

    $respuesta.="<td>" . linkTo("Inicio", direcciones::index) . "</td>";

    $respuesta.="<td></td>";

    $respuesta.= "<td>" . linkTo("Desconectarse", direcciones::logout) . "</td>";


    $respuesta.= "</tr></table>";

    return $respuesta;
}

function linkTo($texto, $pagina) {
    return "<a href=\"$pagina\">$texto</a>";
}

function listadoSituaciones() {

    $situaciones = getSituaciones();



    $respuesta = "<ul>";

    foreach ($situaciones as $situacion) {

        $respuesta .= "<li>$situacion->resumen</li>";
    }

    $respuesta .= "</ul>";

    return $respuesta;
}

function tablaObjetivos() {
    $objetivos = getObjetivos();

    $respuesta = "<table border='1'>";

    $respuesta .= "<tr>"
            . "<th>Objetivos</th>"
            . "</tr>";

    foreach ($objetivos as $objetivo) {

        $respuesta .= "<tr>"
                . "<td><a href='showEstado.php?tipo=objetivo&id=" . $objetivo->id . "'>$objetivo->resumen</a></td>"
                . "</tr>";
    }

    //Añadimos el formulario para añadir más
    $respuesta .= "<tr><td>"
            . "<form method='post' action='addobjetivo.php'>"
            . "<input type='text' name='resumen' placeholder='añadir objetivo'>"
            . "</form>"
            . "</td></tr>";



    $respuesta .= "</table>";

    return $respuesta;
}

function tablaSituaciones() {
    $situaciones = getSituaciones();

    $respuesta = "<table border='1'>";

    $respuesta .= "<tr>"
            . "<th>Situaciones</th>"
            . "</tr>";

    foreach ($situaciones as $situacion) {

        $respuesta .= "<tr>"
                . "<td><a href='showEstado.php?tipo=situacion&id=" . $situacion->id . "'>$situacion->resumen</a></td>"
                . "</tr>";
    }

    //Añadimos el formulario para añadir más
    $respuesta .= "<tr><td>"
            . "<form method='post' action='addsituacion.php'>"
            . "<input type='text' name='resumen' placeholder='añadir situación'>"
            . "</form>"
            . "</td></tr>";



    $respuesta .= "</table>";

    return $respuesta;
}

function form_addsituacion() {
    return "<form method=\"POST\" action=\"addsituacion.php\">"
            . "Resumen<input type=\"text\" id=\"resumen_txt\" name=\"resumen\"><br/>"
            . "Descripción<input type=\"text\" id=\"descripcion_txt\" name=\"descripcion\"><br/>"
            . "<input type=\"submit\" value=\"OK\">"
            . "</form>";
}

function listadoObjetivos() {

    $objetivos = getObjetivos();



    $respuesta = "<ul>";

    foreach ($objetivos as $objetivo) {

        $respuesta .= "<li>$objetivo->resumen</li>";
    }

    $respuesta .= "</ul>";

    return $respuesta;
}
