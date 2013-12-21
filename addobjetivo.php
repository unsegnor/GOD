<?php

include "controlador.php";

//Recibimos los parámetros

$resumen = $_POST['resumen'];
$descripcion = $_POST['descripcion'];
//$caducidad = $_POST['caducidad'];
//Conformamos el objetivo
$s = new Objetivo();

$s->descripcion = $descripcion;
$s->resumen = $resumen;

//Añadimos el objetivo
$res = addObjetivo($s);

//Si todo ha ido bien miramos si es causa o consecuencia de algo
if (!$res->hayerror) {

    //Recuperamos el id que hemos creado
    $id_nuevo = $res->resultado;

    //Comprobamos si es subobjetivo
    if (isset($_REQUEST['subobjetivo'])) {
        $id_subobjetivo = $_REQUEST['subobjetivo'];
        $id_superobjetivo = $id_nuevo;

        addSubObjetivo($id_subobjetivo, $id_superobjetivo);
    } else if (isset($_REQUEST['superobjetivo'])) {
        $id_superobjetivo = $_REQUEST['superobjetivo'];
        $id_subobjetivo = $id_nuevo;

        addSubObjetivo($id_subobjetivo, $id_superobjetivo);
    } else if (isset($_REQUEST['propuesta'])) {
        //Si es una propuesta a una situación
        $id_situacion = $_REQUEST['propuesta'];
        $id_propuesta = $id_nuevo;

        addPropuesta($id_situacion, $id_propuesta);
    }

    
}

if (!$res->hayerror) {
    redirect("showEstado.php?tipo=objetivo&id=$id_nuevo");
} else {
    echo $res->errormsg;
    //redirect(direcciones::index);
}





