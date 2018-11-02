<?php 
    
    // Se crea un objeto del tipo Controlador
    $equipos = new Controlador();

    // Se guarda en un array los datos traidos del método para obtener los
    // datos del equipo
    $datosEquipos = $equipos->obtenerDatosEquipos();


    // Si se dio clic en el botón de eliminar
    if(isset($_GET["accion"])){
        if ($_GET["accion"] == "eliminar_equipo") {
            // Se manda llamar al método para eliminar equipo
            $equipos->eliminarEquipo();
            //echo "Clic en eliminar";
        }
    }
 ?>

<section class="content-header">
    <h1>
        Equipos Registrados
    </h1>
    
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Equipos </a></li>
        <li class="active"> Lista de equipos </li>
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
                    <th>Nombre</th>
                    <th>Deporte</th>
                    <th>Detalles</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Ciclo en cual se muestran todos los equipos del sistema
                    for($i=0; $i<count($datosEquipos); $i++){
                        echo "<tr>";                        
                        echo "<td>" . $datosEquipos[$i]["nombre"] . "</td>";
                        //echo "<td>" . $datosEquipos[$i]["deporte_id"] . "</td>";
                        // Se llama al método para obtener el nombre del deporte por id
                        $deporte = $equipos->obtenerDeportePorId($datosEquipos[$i]["deporte_id"]);
                        // Se muestra el nombre del deporte        
                        echo "<td>" . $deporte["nombre"] . "</td>";

                         //Estos dos de abajo son los botones, se puede observar que estan listos para redirigir el flujo de la app a una pagina que se llama editar y eliminar, teniendo un parametro el cual es la matricula del alumno a administrar

                        echo '<td> <a href="index.php?action=ver_equipo&id='.$datosEquipos[$i]['equipo_id'].'" type="button" class="btn btn-primary"> <i class="fas fa-search"></i> </a> </td>';

                        echo '<td> <a href="index.php?action=editar_equipo&id='.$datosEquipos[$i]['equipo_id'].'" type="button" class="btn btn-warning"> <i class="fas fa-edit"></i> </a> </td>';
                        
                        echo '<td>  <a href="index.php?action=equipos&accion=eliminar_equipo&id='.$datosEquipos[$i]['equipo_id'].'" type="button"  class="btn btn-danger"> <i class="fas fa-trash-alt"></i>  </a> </td>';
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
</section>