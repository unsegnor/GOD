<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
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
        
        if (isset($_SESSION['loged_in'])) {
            echo getMenu();
            
            //echo getTablaEstados();
            
            echo "<table>";
            echo "<tr><td>";
            echo tablaSituaciones();
            echo "</td><td>";
            echo tablaObjetivos();
            echo "</td></tr>";
            echo "</table>";
            
        } else {
            $formulario_login = getFormularioLogin();
            echo $formulario_login;
            echo linkTo("Registrarme!", direcciones::registroWeb);
        }
        ?>
    </body>
</html>
