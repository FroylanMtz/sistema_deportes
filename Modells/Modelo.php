<?php

class Modelo
{

    //Una funcion con el parametro $enlacesModel que se recibe a traves del controlador

    public function mostrarPagina($enlace){

        //Posible paginas para los tutores
        if( $enlace == "jugadores"  ||
            $enlace == "equipos" ||
            $enlace == "deportes" ||
            $enlace == "salir" ||
            $enlace == "usuarios" ||
            $enlace == "agregar_usuario" ||
            $enlace == "editar_usuario" ||
            $enlace == "agregar_jugador" ||
            $enlace == "editar_jugador" ||
            $enlace == "equipos" ||
            $enlace == "agregar_equipo" ||
            $enlace == "editar_equipo" ||
            $enlace == "ver_equipo" ||
            $enlace == "agregar_jugador_a_equipo" )
        {
            //Mostramos el URL concatenado con la variable $enlacesModel
            $pagina = "Views/Paginas/". $enlace .".php";
        }

        //Una vez que action vienen vacio (validnaod en el controlador) enctonces se consulta si la variable $enlacesModel es igual a la cadena index de ser asi se muestre index.php
        else if($enlace == "index"){
            $pagina = "Views/Paginas/Tutores/jugadores.php";
        }
        //Validar una LISTA BLANCA 
        else{
            $pagina = "Views/Paginas/Tutores/jugadores.php";
        }

        return $pagina;
    }

}