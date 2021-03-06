<?php 

    // Se traen los datos de los deportes para seleccionarlos en el select del form
    // Se instancia un objeto del tipo controlador
    $deportes = new Controlador();

    // Se llama al método para obtener los datos de los equipos
    $datosDeportes =  $deportes->obtenerDatosDeportes();


    // Si se presionó el botón de guardar
    if(isset($_POST["guardar"])){
        // Se llama al método para guardar los datos del nuevo equipo
        //echo "Llamada al método";
        $deportes->agregarNuevoEquipo();
    }
 ?>

<section class="content-header">
    <h1>
        Agregar Equipo
    </h1>
    
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Equipos </a></li>
        <li class="active">Agregar Equipo </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">


<div class="row">

    <div class="col-md-12">

        <!-- general form elements -->
        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">Agregue los datos del equipo</h3>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" enctype="multipart/form-data">
                
                <div class="box-body">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre del equipo" size="50" required>
                </div>

                <div class="form-group">
                    <label for="tutor">Deporte</label>
                    <select class="form-control" name="deporte">
                        <?php
                           // Se muestran los diferentes datos de los equipos
                            for($i=0; $i<count($datosDeportes); $i++){
                                echo "<option>";
                                echo $datosDeportes[$i]["nombre"];
                                echo "</option>";
                            }
                        ?>
                    </select>
                </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                <center> <input type="submit" class="btn btn-primary input-lg" value="Guardar Datos" name="guardar" /> </center>
                </div>
                
            </form>

        </div>
        <!-- /.box -->
    </div>
</div>
<!-- /.row -->

</section>
