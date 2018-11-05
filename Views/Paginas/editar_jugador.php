<?php
//Se instancia a un objeto de l clase controlador para que se manden llamar todos los metodo que cominican a la vista con el controlador
$controlador = new Controlador();


//Se crea un array que va a recibir todos los obejtos 
$datosJugador = array();

//Y se llena ese array con la respuesta con los datos
$datosJugador = $controlador->obtenerDatosJugador();

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
                <h3 class="box-title">Edite los datos del jugador</h3>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" enctype="multipart/form-data">
                
                <div class="box-body">
                
                <input name="fotoActual" type="hidden" value="<?= $datosJugador[0]['foto'] ?>" />

                <div class="form-group">
                    <label >Foto Actual:</label>
                    <img src="fotos_jugadores/<?= $datosJugador[0]['foto'] ?>" width="100px" height="100px" />
                </div>

                <div class="form-group">
                    <label for="matricula">Matricula</label>
                    <input type="number" class="form-control" name="matricula" placeholder="Ingrese la matricula" value="<?= $datosJugador[0]['matricula'] ?>" size="10" disabled required>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre del jugador" value="<?= $datosJugador[0]['nombre'] ?>" size="50" required>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" name="apellido" placeholder="Apellido del jugador" value="<?= $datosJugador[0]['apellido'] ?>" size="50" required>
                </div>

                
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" class="form-control" name="correo" placeholder="alguien@ejemplo.com" value="<?= $datosJugador[0]['correo'] ?>" size="50" required>
                </div>

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
if(isset($_POST['nombre'])){
    
    //Funcion del controlador que permite la lecutra de todas las variables del formulario para reunirlas en un objeto y posteriormente pasarlas al modelo apra que la almacene
    $controlador -> editarDatosJugador();

    
}


?>