<!DOCTYPE html>
<!--
Aquí mostramos un estado y sus opciones
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="stilos.css">
        <title></title>
    </head>
    <body>
        <?php
        include "vistas.php";
        
        
        echo getMenu();

        //Recuperamos el tipo y el estado que estamos viendo
        $tipo = $_REQUEST['tipo'];
        $id = $_REQUEST['id'];

        if ($tipo == "situacion") {
            //Recuperamos la situación
            $situacion = getSituacionPorId($id);

            //Mostramos el resumen en el centro
            echo "<h1>".$situacion->resumen."</h1>";

            //Mostramos las causas
            $causas = getCausas($id);

            echo "<table border='1'>";

            echo "<tr><th>Causas</th></tr>";

            foreach ($causas as $causa) {

                echo "<tr>"
                . "<td><a href='showEstado.php?tipo=situacion&id=" . $causa->id . "'>$causa->resumen</a></td>"
                . "</tr>";
            }


            echo"<tr><td>";
            //Mostramos el formulario de añadir causa
            echo "<form method='post' action='addsituacion.php'>"
            . "<input type='text' name='resumen' placeholder='añadir causa'>"
            . "<input type='hidden' name='consecuencia' value='$id'>"
            . "</form>";
            echo "</td></tr>";
            echo "</table>";

            //Mostramos las consecuencias
            $consecuencias = getConsecuencias($id);

            echo "<table border='1'>";

            echo "<tr><th>Consecuencias</th></tr>";

            foreach ($consecuencias as $consecuencia) {

                echo "<tr>"
                . "<td><a href='showEstado.php?tipo=situacion&id=" . $consecuencia->id . "'>$consecuencia->resumen</a></td>"
                . "</tr>";
            }


            echo"<tr><td>";
            //Mostramos el formulario de añadir causa
            echo "<form method='post' action='addsituacion.php'>"
            . "<input type='text' name='resumen' placeholder='añadir consecuencia'>"
            . "<input type='hidden' name='causa' value='$id'>"
            . "</form>";
            echo "</td></tr>";
            echo "</table>";

            //Mostramos los objetivos propuestos
            $propuestas = getObjetivosPropuestos($id);

            echo "<table border='1'>";

            echo "<tr><th>Propuestas</th></tr>";

            foreach ($propuestas as $propuesta) {

                echo "<tr>"
                . "<td><a href='showEstado.php?tipo=objetivo&id=" . $propuesta->id . "'>$propuesta->resumen</a></td>"
                . "</tr>";
            }


            echo"<tr><td>";
            //Mostramos el formulario de añadir causa
            echo "<form method='post' action='addobjetivo.php'>"
            . "<input type='text' name='resumen' placeholder='añadir propuesta'>"
            . "<input type='hidden' name='propuesta' value='$id'>"
            . "</form>";

            echo "</td></tr>";

            echo "</table>";
        } else if ($tipo == "objetivo") {
            //Recuperamos el objetivo
            $objetivo = getObjetivoPorId($id);

            //Mostramos el resumen en el centro
            echo "<h1>".$objetivo->resumen."</h1>";

            //Mostramos los subobjetivos
            $subobjetivos = getSubobjetivos($id);

            echo "<table border='1'>";

            echo "<tr><th>¿Cómo?</th></tr>";

            foreach ($subobjetivos as $subobjetivo) {

                echo "<tr>"
                . "<td><a href='showEstado.php?tipo=objetivo&id=" . $subobjetivo->id . "'>$subobjetivo->resumen</a></td>"
                . "</tr>";
            }


            echo"<tr><td>";
            //Mostramos el formulario de añadir subobjetivo
            echo "<form method='post' action='addobjetivo.php'>"
            . "<input type='text' name='resumen' placeholder='añadir subobjetivo'>"
            . "<input type='hidden' name='superobjetivo' value='$id'>"
            . "</form>";
            echo "</td></tr>";
            echo "</table>";

            //Mostramos los superobjetivos
            $superobjetivos = getSuperobjetivos($id);

            echo "<table border='1'>";

            echo "<tr><th>¿Para qué?</th></tr>";

            foreach ($superobjetivos as $superobjetivo) {

                echo "<tr>"
                . "<td><a href='showEstado.php?tipo=objetivo&id=" . $superobjetivo->id . "'>$superobjetivo->resumen</a></td>"
                . "</tr>";
            }


            echo"<tr><td>";
            //Mostramos el formulario de añadir causa
            echo "<form method='post' action='addobjetivo.php'>"
            . "<input type='text' name='resumen' placeholder='añadir motivo'>"
            . "<input type='hidden' name='subobjetivo' value='$id'>"
            . "</form>";
            echo "</td></tr>";
            echo "</table>";

            //Mostramos las situaciones relacionadas
            /*
            $propuestas = getObjetivosPropuestos($id);

            echo "<table border='1'>";

            echo "<tr><th>Propuestas</th></tr>";

            foreach ($propuestas as $propuesta) {

                echo "<tr>"
                . "<td><a href='showEstado.php?tipo=objetivo&id=" . $propuesta->id . "'>$propuesta->resumen</a></td>"
                . "</tr>";
            }


            echo"<tr><td>";
            //Mostramos el formulario de añadir causa
            echo "<form method='post' action='addobjetivo.php'>"
            . "<input type='text' name='resumen' placeholder='añadir propuesta'>"
            . "<input type='hidden' name='propuesta' value='$id'>"
            . "</form>";

            echo "</td></tr>";

            echo "</table>";
             */
        }
        
        //Permitimos votar el estado
        echo getBotonesVoto($id);
        
        ?>
    </body>
</html>
