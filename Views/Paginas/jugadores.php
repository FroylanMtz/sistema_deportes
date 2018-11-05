<?php

//Lista de todos los alumnos registrados en la tabla alumnos

//Se crea un objeto de tipo controlador para poder llamar los metodos para traer toda la informacion
$controlador = new Controlador();

//Se crea un array que va a recibir todos los obejtos 
$datosJugadores = array();

//Y se llena ese array con la respuesta con los datos
$datosJugadores = $controlador -> obtenerDatosJugadores();
$datosEquipoJugador = $controlador -> traerDatosEquipoJugador();

?>

<section class="content-header">
    <h1>
        Jugadores
    </h1>
    
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Jugadores </a></li>
        <li class="active"> Lista de jugadores </li>
    </ol>

</section>

<!-- Main content -->
<section class="content">


<div class="box box-primary">

<div class="box">

    <div class="box-header">
        <!--<h3 class="box-title">Data Table With Full Features</h3> -->
        <a href="index.php?action=agregar_jugador" class="btn btn-primary " > <i class="fas fa-plus-square"></i> Agregar nuevo jugador </a>
        <hr>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <table id="tabla" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <!--Columnas de la cabecera de la tabla-->
                    <th>Foto</th>
                    <th>Matricula</th>
                    <th>Nombre (s)</th>
                    <th>Apellido (s)</th>
                    <th>Correo</th>
                    <th>Equipo (s)</th>

                    <th>Detalles</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //La tabla es llenada dinamicamente creando una nueva fila por cada registro en la tabla, toda la ifnormacion que aqui se despliega se trajo desde el controler con el metodo anteriormente definido
                    for($i=0; $i < count($datosJugadores); $i++ ){
                        echo '<tr>';
                            echo '<td> <img src="fotos_jugadores/'. $datosJugadores[$i]['foto'] .'" width="100px" height="100px" /> </td>';
                            echo '<td>'. $datosJugadores[$i]['matricula'] .'</td>';
                            echo '<td>'. $datosJugadores[$i]['nombre'] .'</td>';
                            echo '<td>'. $datosJugadores[$i]['apellido'] .'</td>';
                            echo '<td>'. $datosJugadores[$i]['correo'] .'</td>';

                            // Estas dos variables y el ciclo son para mostrar los equipos a los que pertenece cierto jugador
                            $equipos = 0;
                            $todosLosEquipos = "";

                            for($j=0; $j < count($datosEquipoJugador); $j++ ){
                                
                                if($datosJugadores[$i]['matricula'] == $datosEquipoJugador[$j]['matricula'] ){
                                    
                                    $todosLosEquipos = $todosLosEquipos . $datosEquipoJugador[$j]['equipo'] . ' - '. $datosEquipoJugador[$j]['deporte'] . '<br/>';

                                    $equipos++;
                                }
                            }

                            if($equipos == 0){
                                echo '<td> No está en ningun equipo </td>';
                            }else{
                                echo '<td>' . $todosLosEquipos . '</td>';
                            }

                            /*echo '<td>'. $datosJugadores[$i]['equipo'] .'</td>';
                            echo '<td>'. $datosJugadores[$i]['deporte'] .'</td>';*/

                            //Estos dos de abajo son los botones, se puede observar que estan listos para redirigir el flujo de la app a una pagina que se llama editar y eliminar, teniendo un parametro el cual es la matricula del alumno a administrar
                            echo '<td> <a href="index.php?action=ver_jugador&id='.$datosJugadores[$i]['matricula'].'" type="button" class="btn btn-primary"> <i class="fas fa-search"></i> </a> </td>';

                            echo '<td> <a href="index.php?action=editar_jugador&id='.$datosJugadores[$i]['matricula'].'" type="button" class="btn btn-warning"> <i class="fas fa-edit"></i> </a> </td>';
                            
                            echo '<td>  <a href="index.php?action=jugadores&accion=eliminar_jugador&id='.$datosJugadores[$i]['matricula'].'" type="button"  class="btn btn-danger"> <i class="fas fa-trash-alt"></i>  </a> </td>';
                        echo '</tr>';
                    }
                
                ?>
            </tbody>
        </table>
    </div>
</div>

    

</section>


<?php

//Valida que se accion el metodo solo si se hace clic en el boton y no cuando se cargue pagina
if(isset($_GET['accion'])) {
    if( $_GET['accion'] == "eliminar_jugador"){
        $controlador -> eliminarJugador();
    }
}

?>
