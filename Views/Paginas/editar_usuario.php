<?php
    $controlador = new Controlador();//Llamar al controlador
    $datosUsuario = array();//Hacer array para los datos
    $datosUsuario = $controlador->obtenerDatosUsuarioId();//Obtener los datos del usuario
?>
<section class="content-header">
    <h1>
        Editar Usuario
        
    </h1>
     <br>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Usuarios</a></li>
        <li class="active">Editar Usuarios</li>
    </ol>
    <div class="box box-primary">
           
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method='post'>
              <div class="box-body">
                <div class="form-group">
                  <label for="carrera_id">Id del usuario</label>
                  <input type="text" name="carrera_id" value="<?= $datosUsuario[0]['usuario_id'] ?>" disabled>
                </div>

                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" class="form-control" id="nombre" placeholder="Escribe tu nombre" name="nombre" value="<?= $datosUsuario[0]['nombre'] ?>">
                </div>

                <div class="form-group">
                  <label for="correo">Correo</label>
                  <input type="email" class="form-control" id="correo" placeholder="Escribe tu correo" name="correo" value="<?= $datosUsuario[0]['correo'] ?>">
                </div>

                <div class="form-group">
                  <label for="contra">Contraseña</label>
                  <input type="password" class="form-control" id="contra" placeholder="Escribe tu contraseña" name="contra" value="<?= $datosUsuario[0]['contrasena'] ?>">
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" value="Actualizar">Enviar</button>
              </div>
            </form>
          </div>

</section>
<?php
if(isset($_POST['nombre'])){
        
    $controlador -> editarDatosUser();

}

?>