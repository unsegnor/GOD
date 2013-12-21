<?php

include "conexionbdd.php";

function addSituacion(Situacion $situacion) {

    $consulta = "INSERT INTO `Estados` (`resumen`, `descripcion`) VALUES ('" . escape($situacion->resumen) . "','" . escape($situacion->descripcion) . "')";

    $id = insert_id($consulta);

    $consulta2 = "INSERT INTO `Situaciones` (`id_situacion`) VALUES (" . $id . ")";

    $res = ejecutar($consulta2);

    //Si no hay errores devolvemos el id de la situación
    if (!$res->hayerror) {
        $res->resultado = $id;
    }

    return $res;
}

function addVotoEstado($id_usuario, $id_estado, $voto) {

    $consulta = "INSERT INTO `GOD`.`Votaciones` (`id_usuario`, `id_estado`, `inclinacion`) VALUES ('" . escape($id_usuario) . "', '" . escape($id_estado) . "', '" . escape($voto) . "')";

    $res = ejecutar($consulta);

    if (!$res->hayerror) {
        //Si todo ha ido bien anotamos también el voto en el estado
        if ($voto == 1) {
            $consulta2 = "UPDATE estados SET votos_positivos=votos_positivos+1 WHERE id_estado='" . escape($id_estado) . "'";
        } else if ($voto == -1) {
            $consulta2 = "UPDATE estados SET votos_negativos=votos_negativos+1 WHERE id_estado='" . escape($id_estado) . "'";
        }
        
        $res = ejecutar($consulta2);
    }
    
    return $res;
}

function addObjetivo(Objetivo $objetivo) {

    $consulta = "INSERT INTO `Estados` (`resumen`, `descripcion`) VALUES ('" . escape($objetivo->resumen) . "','" . escape($objetivo->descripcion) . "')";

    $id = insert_id($consulta);

    $consulta2 = "INSERT INTO `Objetivos` (`id_objetivo`) VALUES (" . $id . ")";

    $res = ejecutar($consulta2);

    //Si no hay errores devolvemos el id del objetivo
    if (!$res->hayerror) {
        $res->resultado = $id;
    }

    return $res;
}

function addCausa($id_causa, $id_consecuencia) {

    $consulta = "INSERT INTO `GOD`.`Causas` (`id_causa`, `id_consecuencia`) VALUES ('" . $id_causa . "','" . $id_consecuencia . "')";

    return ejecutar($consulta);
}

function addPropuesta($id_situacion, $id_propuesta) {

    $consulta = "INSERT INTO `GOD`.`Propuestas` (`id_situacion_e`, `id_objetivo_e`) VALUES ('" . escape($id_situacion) . "','" . escape($id_propuesta) . "')";

    return ejecutar($consulta);
}

function addSubObjetivo($id_subobjetivo, $id_superobjetivo) {

    $consulta = "INSERT INTO `GOD`.`Subobjetivos` (`id_superobjetivo`, `id_subobjetivo`) VALUES ('" . escape($id_superobjetivo) . "','" . escape($id_subobjetivo) . "')";

    return ejecutar($consulta);
}

function getCausas($id_consecuencia) {

    $consulta = "SELECT * FROM situaciones, estados, causas WHERE id_situacion=id_estado AND id_causa=id_situacion AND id_consecuencia='" . escape($id_consecuencia) . "'";

    $resultado = ejecutar($consulta)->resultado;

    $array = toArray($resultado);

    $respuesta = situacionesConvert($array);

    return $respuesta;
}

function getConsecuencias($id_causa) {
    $consulta = "SELECT * FROM situaciones, estados, causas WHERE id_situacion=id_estado AND id_consecuencia=id_situacion AND id_causa='" . escape($id_causa) . "'";

    $resultado = ejecutar($consulta)->resultado;

    $array = toArray($resultado);

    $respuesta = situacionesConvert($array);

    return $respuesta;
}

function getSubobjetivos($id_superobjetivo) {

    $consulta = "SELECT * FROM objetivos, estados, subobjetivos WHERE id_objetivo=id_estado AND id_subobjetivo=id_objetivo AND id_superobjetivo='" . escape($id_superobjetivo) . "'";

    $resultado = ejecutar($consulta)->resultado;

    $array = toArray($resultado);

    $respuesta = objetivosConvert($array);

    return $respuesta;
}

function getSuperobjetivos($id_subobjetivo) {

    $consulta = "SELECT * FROM objetivos, estados, subobjetivos WHERE id_objetivo=id_estado AND id_superobjetivo=id_objetivo AND id_subobjetivo='" . escape($id_subobjetivo) . "'";

    $resultado = ejecutar($consulta)->resultado;

    $array = toArray($resultado);

    $respuesta = objetivosConvert($array);

    return $respuesta;
}

function getObjetivosPropuestos($id_situacion) {

    $consulta = "SELECT * FROM objetivos, estados, propuestas WHERE id_objetivo=id_estado AND id_objetivo=id_objetivo_e AND id_situacion_e='" . escape($id_situacion) . "'";

    $resultado = ejecutar($consulta)->resultado;

    $array = toArray($resultado);

    $respuesta = objetivosConvert($array);

    return $respuesta;
}

function getSituacionPorId($id) {

    $consulta = "SELECT * FROM situaciones, estados WHERE id_situacion=id_estado AND id_situacion='" . escape($id) . "'";

    $resultado = ejecutar($consulta)->resultado;

    $fila = $resultado->fetch_assoc();

    $situacion = situacionConvert($fila);

    return $situacion;
}

function getObjetivoPorId($id) {

    $consulta = "SELECT * FROM objetivos, estados WHERE id_objetivo=id_estado AND id_objetivo='" . escape($id) . "'";

    $resultado = ejecutar($consulta)->resultado;

    $fila = $resultado->fetch_assoc();

    $situacion = objetivoConvert($fila);

    return $situacion;
}

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
            } else {
                $res->resultado = null;
                $res->hayerror = true;
                $res->errormsg = "Contraseña incorrecta.";
            }
        } else {
            $res->resultado = null;
            $res->hayerror = true;
            $res->errormsg = "Login incorrecto";
        }
    } else {
        $res->resultado = null;
    }


    return $res;
}

function login_libre($login) {


    $consulta = "SELECT login FROM usuarios WHERE login ='" . escape($login) . "'";

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

    $consulta = "INSERT INTO usuarios (login, pass) values ('" . escape($login) . "','" . escape($sha_pass) . "')";

    return ejecutar($consulta);
}

function getSituaciones() {

    $consulta = "SELECT * FROM situaciones, estados WHERE id_situacion = id_estado";

    $resultado = ejecutar($consulta)->resultado;

    $array = toArray($resultado);

    $respuesta = situacionesConvert($array);

    return $respuesta;
}

function situacionesConvert($array) {

    $respuesta = array();

    foreach ($array as $fila) {

        $respuesta[] = situacionConvert($fila);
    }

    return $respuesta;
}

function situacionConvert($fila) {

    $situacion = new Situacion();

    $estado = estadoFill($situacion, $fila);

    $situacion->problematica = $fila['problematica'];

    return $situacion;
}

function estadoFill(Estado $estado, $fila) {
    $estado->id = $fila['id_estado'];
    $estado->caducidad = $fila['caducidad'];
    $estado->descripcion = $fila['descripcion'];
    $estado->entrada_en_vigor = $fila['entrada_en_vigor'];
    $estado->resumen = $fila['resumen'];
    $estado->votos_negativos = $fila['votos_negativos'];
    $estado->votos_positivos = $fila['votos_positivos'];
}

function estadoConvert($fila) {
    $estado = new Estado();

    estadoFill($estado, $fila);

    return $estado;
}

function redirect($nombre_pagina) {
    header("location:$nombre_pagina");
}

function getObjetivos() {

    $consulta = "SELECT * FROM objetivos, estados WHERE id_objetivo = id_estado";

    $resultado = ejecutar($consulta)->resultado;

    $array = toArray($resultado);

    $respuesta = objetivosConvert($array);

    return $respuesta;
}

function objetivosConvert($array) {

    $respuesta = array();

    foreach ($array as $fila) {

        $respuesta[] = objetivoConvert($fila);
    }

    return $respuesta;
}

function objetivoConvert($fila) {

    $objetivo = new Objetivo();

    $estado = estadoFill($objetivo, $fila);

    $objetivo->tiempo_estimado = $fila['tiempo_estimado'];

    return $objetivo;
}
