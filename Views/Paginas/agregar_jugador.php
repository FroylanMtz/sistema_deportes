<?php
//Se instancia a un objeto de l clase controlador para que se manden llamar todos los metodo que cominican a la vista con el controlador
$controlador = new Controlador();

//Se crean dos arreglos para recibir la informacion de las carreras y los tutores
$datosEquipos = array();

//Se mandan llamar los metodos que traen estos datos, estos retornan un arreglo asociativo, esta informacion sera desplegada en los campos del formulario en donde se necesite mostrar los datos de la tabla que existen
$datosEquipos = $controlador -> obtenerDatosEquipos();

?>

<section class="content-header">
    <h1>
        Agregar Jugador
    </h1>
    
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Jugador </a></li>
        <li class="active">Agregar Jugador </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">


<div class="row">

    <div class="col-md-12">

        <!-- general form elements -->
        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">Agregue los datos del jugador</h3>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" enctype="multipart/form-data">
                
                <div class="box-body">
            
                <div class="form-group">
                    <label for="matricula">Matricula</label>
                    <input type="number" class="form-control" name="matricula" placeholder="Ingrese la matricula" size="10" required>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre del jugador" size="50" required>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" name="apellido" placeholder="Apellido del jugador" size="50" required>
                </div>

                
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" class="form-control" name="correo" placeholder="alguien@ejemplo.com" size="50" required>
                </div>

                <!--<div class="form-group">
                    <label for="tutor">Equipo</label>
                    <select class="form-control" name="equipo">
                        <?php
                            /*for($i = 0; $i < count($datosEquipos); $i++ ){
                                echo '<option value="'.$datosEquipos[$i]['equipo_id'].'"> '. $datosEquipos[$i]['nombre'] .' </option>';
                            }*/
                        ?>
                    </select>
                </div> -->

                <!--Campo que subre la fotografia al servidor, lo coloca en una carpeta temporal desde donde se toma y se almacena en una carpeta especificada, para poder subir la imagen en el formulario se debe cambiar el encabezado a tipo  enctype="multipart/form-data" -->
                <div class="form-group">
                    <label for="foto">Fotografia</label> <br>
                    <input type="file" class="form-control input-lg" name="foto"  />
                </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                <center> <input type="submit" class="btn btn-primary input-lg" value="Guardar Datos" /> </center>
                </div>
                
            </form>

        </div>
        <!-- /.box -->
    </div>
</div>
<!-- /.row -->

</section>

<?php

//Compara si la variable exista, para que cuando entre sin que se le haya pulsado al boton esto no se accione y trate de hacer algo, eso solo se habilitara cuando el usaurio de click en el boton, es lo que significa
if(isset($_POST['matricula'])){
    
    //Funcion del controlador que permite la lecutra de todas las variables del formulario para reunirlas en un objeto y posteriormente pasarlas al modelo apra que la almacene
    $controlador ->  guardarDatosJugador();

}

?>