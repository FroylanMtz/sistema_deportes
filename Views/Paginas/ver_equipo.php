<?php 
    
    // Se crea un objeto del tipo Controlador
    $equipo = new Controlador();

    // Se guarda en un array los datos traidos del método para obtener los
    // juhadores de ese equipo
    $jugadoresEquipo = $equipo->obtenerJugadoresEquipo();

    //Obtener los datos del equipo (para colocar el nombre)
    $datosEquipo = $equipo->obtenerUnEquipo();
   
 ?>

<section class="content-header">
    <h1>
        Lista de jugadores: <strong> <?php echo $datosEquipo["nombre"]; ?> </strong>
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
        <a href="index.php?action=agregar_equipo" class="btn btn-primary " > <i class="fas fa-plus-square"></i> Agregar nuevo equipo </a>
        <hr>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <table id="tabla" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <!--Columnas de la cabecera de la tabla-->
                    <th>Matricula</th>
                    <th>Nombre</th>
                    <th>Correo</th>                    
                </tr>
            </thead>
            <tbody>
                <?php
                    // Ciclo en cual se muestran todos los equipos del sistema
                    for($i=0; $i<count($jugadoresEquipo); $i++){
                        echo "<tr>";                        
                        echo "<td>" . $jugadoresEquipo[$i]["matricula"] . "</td>";
                        echo "<td>" . $jugadoresEquipo[$i]["nombre"] . "</td>";
                        echo "<td>" . $jugadoresEquipo[$i]["equipo_id"] . "</td>";
                        //echo "<td>" . $jugadoresEquipo[$i]["deporte_id"] . "</td>";
                        // Se llama al método para obtener el nombre del deporte por id
                        //$deporte = $equipo->obtenerDeportePorId($jugadoresEquipo[$i]["deporte_id"]);
                        // Se muestra el nombre del deporte        
                        //echo "<td>" . $deporte["nombre"] . "</td>";

                         // Botón para ver los datos con más detalle del jugador

                        echo '<td> <a href="index.php?action=ver_jugador&id='.$jugadoresEquipo[$i]['equipo_id'].'" type="button" class="btn btn-primary"> <i class="fas fa-search"></i> </a> </td>';                       
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
</section>