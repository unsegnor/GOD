<?php

include "controlador.php";

//Recibimos los parámetros

$resumen = $_POST['resumen'];
$descripcion = $_POST['descripcion'];
//$caducidad = $_POST['caducidad'];
//Conformamos la situación
$s = new Situacion();

$s->descripcion = $descripcion;
$s->resumen = $resumen;

//Añadimos la situación
$res = addSituacion($s);

//Si todo ha ido bien miramos si es causa o consecuencia de algo
if (!$res->hayerror) {

    //Recuperamos el id que hemos creado
    $id_nuevo = $res->resultado;

    //Comprobamos si es consecuencia
    if (isset($_REQUEST['consecuencia'])) {
        $id_consecuencia = $_REQUEST['consecuencia'];
        $id_causa = $id_nuevo;

        addCausa($id_causa, $id_consecuencia);
    } else if (isset($_REQUEST['causa'])) {
        $id_causa = $_REQUEST['causa'];
        $id_consecuencia = $id_nuevo;

        addCausa($id_causa, $id_consecuencia);
    }

    redirect("showEstado.php?tipo=situacion&id=$id_nuevo");
}else{
    redirect(direcciones::index);
}





