<?php
  //Se crea un objeto de tipo controlador para poder llamar los metodos para traer toda la informacion
   $controlador = new Controlador();

  //Se crea un array que va a recibir todos los obejtos 
  $datosUsuario = array();

  //Y se llena ese array con la respuesta con los datos
  $datosUsuario= $controlador -> obtenerDatosUsuarios();
?>

<section class="content-header">
    <h1>
        Usuarios adminsitradores
    </h1>
    
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Usuarios </a></li>
        <li class="active"> Lista de usuarios </li>
    </ol>

</section>

<!-- Main content -->
<section class="content">


<div class="box box-primary">

<div class="box">

    <div class="box-header">
    <!--<h3 class="box-title">Data Table With Full Features</h3> -->
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <table id="tabla" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <!--Columnas de la cabecera de la tabla-->
                    <th>Id</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //La tabla es llenada dinamicamente creando una nueva fila por cada registro en la tabla, toda la ifnormacion que aqui se despliega se trajo desde el controler con el metodo anteriormente definido
                    for($i=0; $i < count($datosUsuario); $i++ ){
                        echo '<tr>';
                            echo '<td>'. $datosUsuario[$i]['usuario_id'] .'</td>';
                            echo '<td>'. $datosUsuario[$i]['usuario'] .'</td>';
                            echo '<td>'. $datosUsuario[$i]['nombre'] .'</td>';
                            echo '<td>'. $datosUsuario[$i]['correo'] .'</td>';
                            //Estos dos de abajo son los botones, se puede observar que estan listos para redirigir el flujo de la app a una pagina que se ellama editar y eliminar, teniendo un parametro el cual es la matricula del alumno a administrar

                            echo '<td> <a href="index.php?action=editar_usuario&id='.$datosUsuario[$i]['usuario_id'].'" type="button" class="btn btn-warning"> <i class="fas fa-edit"></i> </a> </td>';
                            
                            echo '<td>  <a href="index.php?action=usuarios&accion=eliminar_usuario&id='.$datosUsuario[$i]['usuario_id'].'" type="button"  class="btn btn-danger"> <i class="fas fa-trash-alt"></i>  </a> </td>';
                        echo '</tr>';
                    }
                
                ?>
            </tbody>
        </table>
    </div>
</div>
</section>

<?php

//Valida que se accion el metodo solo si se hace clic en el boton y no cuando se cargue pagina
if(isset($_GET['accion'])) {
    if( $_GET['accion'] == "eliminar_usuario"){
        $controlador -> eliminarUsuario();
    }
}

?>