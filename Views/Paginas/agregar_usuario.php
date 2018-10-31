<section class="content-header">
    <h1>
        Agregar Nuevo Usuario
        
    </h1>
     <br>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Usuarios</a></li>
        <li class="active">Agregar Nuevo Usuario</li>
    </ol>
    <div class="box box-primary">
            <form role="form" method='post'>
              <div class="box-body">

                <div class="form-group">
                  <label for="usuario">Usuario</label>
                  <input type="text" class="form-control" id="usuario" placeholder="Escribe el usuario" name="usuario">
                </div>

                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" class="form-control" id="nombre" placeholder="Escribe el nombre" name="nombre">
                </div>

                <div class="form-group">
                  <label for="correo">Correo</label>
                  <input type="email" class="form-control" id="correo" placeholder="Escribe el correo" name="correo">
                </div>

                <div class="form-group">
                  <label for="contra">Contraseña</label>
                  <input type="password" class="form-control" id="contra" placeholder="Escribe tu contraseña" name="contra">
                </div>

              </div>
              
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Enviar</button>
              </div>
            
            </form>
          </div>

</section>

<?php
    $controlador= new Controlador();

    $controlador -> agregarUsuario();
?>