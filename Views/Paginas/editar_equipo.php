<?php 

    // Se traen los datos de los deportes para seleccionarlos en el select del form
    // Se instancia un objeto del tipo controlador
    $deportes = new Controlador();

    // Se llama al método para obtener los datos de los equipos
    $datosDeportes =  $deportes->obtenerDatosDeportes();


    // Se obtienen los datos del equipo, se verifica si se trajo el id con GET
    if(isset($_GET["id"])){
        // Se crea un objeto del tipo Controlador
        $equipo = new Controlador();
        // Se llama al método para obtener los datos del equipo y mostrarlos en el form
        $datosEquipo = $equipo->obtenerUnEquipo();
    }

    // Si se presionó el botón de guardar
    if(isset($_POST["actualizar"])){
        // Se llama al método para actualizar
        //echo "Llamada al método";
        $deportes->editarEquipo();
    }
 ?>

<section class="content-header">
    <h1>
        Editar Equipo
    </h1>
    
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Equipos </a></li>
        <li class="active">Editar Equipo </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">


<div class="row">

    <div class="col-md-12">

        <!-- general form elements -->
        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">Actualizar los datos del equipo</h3>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" enctype="multipart/form-data">
                
                <div class="box-body">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre del equipo" size="50" required value="<?php echo($datosEquipo["nombre"]) ?>">
                </div>

                <div class="form-group">
                    <label for="tutor">Deporte</label>
                    <select class="form-control" name="deporte">
                        <?php                            
                            // Se muestra el deporte al que pertenece el equipo
                            // Se llama al método para obtener un deporte por id
                            $nombreDeporte = $equipo->obtenerDeportePorId($datosEquipo["deporte_id"]);
                            echo "<option>";
                            // Con el siguiente echo se muestra el nombre del equipo
                            echo $nombreDeporte["nombre"];

                            echo "</option>";
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
                <center> <input type="submit" class="btn btn-primary input-lg" value="Guardar Datos" name="actualizar" /> </center>
                </div>
                
            </form>

        </div>
        <!-- /.box -->
    </div>
</div>
<!-- /.row -->

</section>
