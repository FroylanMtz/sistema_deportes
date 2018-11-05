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

    <!-- /.box-header -->
    <div class="box-body">
        <table id="tabla" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <!--Columnas de la cabecera de la tabla-->
                    <th>Matricula</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Detalles</th>                
                </tr>
            </thead>
            <tbody>
                <?php
                    // Ciclo en cual se muestran todos los equipos del sistema
                    // Se verifica si no está vacio el array de jugadores
                if($jugadoresEquipo){
                    foreach($jugadoresEquipo as $jugadoresE):
                        echo "<tr>";
                        echo "<td>" . $jugadoresE["matricula"] . "</td>";
                        echo "<td>" . $jugadoresE["nombre"] . "</td>";
                        echo "<td>" . $jugadoresE["correo"] . "</td>";                        
                         // Botón para ver los datos con más detalle del jugador

                        echo '<td> <a href="index.php?action=ver_jugador&id='.$jugadoresE['matricula'].'" type="button" class="btn btn-primary"> <i class="fas fa-search"></i> </a> </td>';                       
                        echo "</tr>";
                    endforeach;
                }                
                ?>
            </tbody>
        </table>
    </div>
</div>
</section>