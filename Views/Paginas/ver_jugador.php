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
        Detalles Jugador <strong><?php echo $datosJugador[0]['matricula']; ?></strong>
    </h1>
    
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Jugador: <?php echo $datosJugador[0]['matricula']; ?> </a></li>
        <li class="active">Detalles Jugador </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">


<div class="row">

    <div class="col-md-12">

        <!-- general form elements -->
        <div class="box box-primary">

           

            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" enctype="multipart/form-data">
                
                <div class="box-body">
                               

                <div class="form-group">                    
                    <img src="fotos_jugadores/<?= $datosJugador[0]['foto'] ?>" width="100px" height="100px" />
                </div>


                <div class="form-group">
                    <label for="nombre">Nombre: <?php echo $datosJugador[0]['nombre']; ?></label>                    
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido: <?php echo $datosJugador[0]['apellido']; ?></label>                    
                </div>

                
                <div class="form-group">
                    <label for="correo">Correo: <?php echo $datosJugador[0]['correo']?> </label>                    
                </div>

               

                </div>
                <!-- /.box-body -->

                
                
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