/*
 * Aquí definimos las funciones y objetos para realizar peticiones AJAX
 */

//Petición AJAX
var AJAXp = function(nombre) {
    //Propiedades
    this.nombre = nombre;
}

function enviarAJAX(objeto, funcion_respuesta) {
        //Inicializamos el objeto XMLHTTPRequest
        if (window.XMLHttpRequest) {
            //Para navegadores modernos
            xmlhttp = new XMLHttpRequest();
        } else {
            //Para Internet Explorer 5 y 6
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                //Tratar respuesta
                //Generamos el objeto respuesta
                
                //alert("Recibido: " + xmlhttp.responseText);
                
                respuesta = JSON.parse(xmlhttp.responseText);
                
                //Llamamos a la función de respuesta con el objeto respuesta
                funcion_respuesta(respuesta);
            }
        }

        //Componemos el cuerpo del mensaje
        cuerpo = JSON.stringify(objeto);

        //Lo metemos todo en un solo parámetro llamado "p"
        params = "p=" + cuerpo;

        xmlhttp.open("POST", "ajaxreceptor.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.setRequestHeader("Content-length", params.length);
        xmlhttp.setRequestHeader("Connection", "close");
        xmlhttp.send(params);
    }
