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
        <script type="text/javascript" src="ajax.js"/>
        <script type="text/javascript">
        
        //definimos la función de envío
        function enviar(){
            
            //Creamos el objeto que vamos a enviar
            var peticion = new AJAXp("addsituacion");
            
            peticion.descripcion = Document.getElementById("descripcion_txt").value;
            peticion.resumen = Document.getElementById("resumen_txt").value;
            peticion.caducidad = Document.getElementById("caducidad_date").value;
            
            enviarAJAX(peticion);
            
        }
        
        
        </script>
        
        <form method="POST" action="addsituacion.php">
            Descripción<input type="text" id="descripcion_txt" name="descripcion"><br/>
            Resumen<input type="text" id="resumen_txt" name="resumen"><br/>
            <!--Caducidad<input type="datetime" id="caducidad_date" name="caducidad"><br/>-->
            <input type="submit" value="OK">
        </form>
    </body>
</html>
