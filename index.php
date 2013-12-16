<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        include "vistas.php";
        
        if (isset($_SESSION['loged_in'])) {
            echo getMenu();
            
            //Permitir añadir una situación
            
            
            
            
            echo listadoSituaciones();
        } else {
            $formulario_login = getFormularioLogin();
            echo $formulario_login;
            echo linkTo("Registrarme!", direcciones::registroWeb);
        }
        ?>
    </body>
</html>
