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
        
        //Mostramos el mensaje de sesión si es que hay
        if(isset($_SESSION['error'])){
            echo $_SESSION['error'];
            //Y lo quitamos de la sesión
            unset($_SESSION['error']);
        }
        
        echo getFormularioRegistro();
        
        ?>
    </body>
</html>
