<?php
//Se instancia a un objeto de l clase controlador para que se manden llamar todos los metodo que cominican a la vista con el controlador
$controlador = new Controlador();


//Se crea un array que va a recibir todos los obejtos 
$datosJugador = array();

//Y se llena ese array con la respuesta con los datos
$datosJugador = $controlador->obtenerDatosJugador();

// Se llama al método del controlador para obtener los equipos a los que pertenece un jugador
$equiposJugador = $controlador->equiposDeJugador();


# DAR DE BAJA UN JUGADOR DE UN EQUIPO ----------
// Si se oprimió el botón de baja se llama al método del controlador correspondiente
if(isset($_GET["accion"])){
    if($_GET["accion"] == "baja"){
        $baja = $controlador->bajaJugadorEquipo();
    }
}
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
                    <img src="fotos_jugadores/<?= $datosJugador[0]['foto'] ?>" width="150px" height="150px" />
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

               <?php 
                    // Se mustren los equipos a los que pertence un jugador
                    if($equiposJugador != null){
                                         
                ?>
                        <!-- BOTÓN PARA ENROLAR EL JUGADOR A UN EQUIPO EQUIPO -->
                           <a href="index.php?action=agregar_jugador_a_equipo&id=<?php echo($datosJugador[0]["matricula"]) ?>" type="button" class="btn btn-success"> <i class="fas fa-edit"></i> Agregar a un equipo </a>
                           <br><br>
                <?php        
                        echo "<strong>Equipos </strong><br><br>";       
                        // Se muestra una tabla con los nombres de los equipos con la 
                        // opción de darlo de baja del equipo
                ?>     
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th> Equipo </th>
                                <th> Dar de baja </th>
                            </thead>
                            <tbody>
                             <?php                              
                               foreach($equiposJugador as $equipos):
                            echo "<tr>";
                               echo "<td><strong>" . $equipos["nombre"] . "</strong></td>";
                             ?> 
                                                                                                
                            <!-- BOTÓN PARA DESENROLAR EL JUGADOR DEL EQUIPO -->
                            <td><a href="index.php?equipo=<?php echo($equipos["equipo_id"]) ?>&id=<?php echo($datosJugador[0]["matricula"]) ?>&action=ver_jugador&accion=baja" type="button" class="btn btn-danger"> <i class="fas fa-edit"></i> Baja </a> </td>
                          <?php 
                                echo "</tr>";
                                endforeach; // Fin foreach
                            } // FIN IF
                            else{
                              echo "Actualmente no se encuentra registrado en ningún equipo ";
                           ?>

                            <!-- BOTÓN PARA ENROLAR EL JUGADOR A UN EQUIPO EQUIPO -->
                           <a href="index.php?action=agregar_jugador_a_equipo&id=<?php echo($datosJugador[0]["matricula"]) ?>" type="button" class="btn btn-success"> <i class="fas fa-edit"></i> Agregar a un equipo </a>
                           <?php                                  
                            }
                          ?>                                                       
                        <!-- SE CIERRA LA TABLA -->
                         </tbody>
                        </table>
                        
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