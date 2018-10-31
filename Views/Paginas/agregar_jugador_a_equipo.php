<?php

//Lista de todos los alumnos registrados en la tabla alumnos

//Se crea un objeto de tipo controlador para poder llamar los metodos para traer toda la informacion
$controlador = new Controlador();

//Se crea un array que va a recibir todos los obejtos 
$datosJugadores = array();

//Y se llena ese array con la respuesta con los datos
$datosJugadores = $controlador -> obtenerDatosJugadores();

$datosEquipos = array();

$datosEquipos = $controlador -> obtenerDatosEquipos();

if(isset( $_POST['jugador'] ) && isset( $_POST['equipo']) ){

    $controlador -> guardar_jugador_equipo();

}


?>

<section class="content-header">
    <h1>
        Agregar Jugador a Equipo
    </h1>
    
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Equipos </a></li>
        <li class="active">Agregar jugador a equipo </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">


<div class="row">

    <div class="col-md-12">

        <!-- general form elements -->
        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">Complete los datos del jugador y del equipo</h3>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST">
                
                <div class="box-body">


                <div class="form-group">
                    <label for="jugador">Jugador</label>
                    <select class="form-control" name="jugador">
                        <?php
                            for($i = 0; $i < count($datosJugadores); $i++ ){
                                echo '<option value="'.$datosJugadores[$i]['matricula'].'"> '. $datosJugadores[$i]['nombre'].' '. $datosJugadores[$i]['apellido'] .' </option>';
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tutor">Equipo</label>
                    <select class="form-control" name="equipo">
                        <?php
                            for($i = 0; $i < count($datosEquipos); $i++ ){
                                echo '<option value="'.$datosEquipos[$i]['equipo_id'].'"> '. $datosEquipos[$i]['nombre'] .' </option>';
                            }
                        ?>
                    </select>
                </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                <center> <input type="submit" class="btn btn-primary" value="Agregar a equipo" /> </center>
                </div>
                
            </form>

        </div>
        <!-- /.box -->
    </div>
</div>
<!-- /.row -->

</section>