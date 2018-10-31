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
                    <select class="form-control" name="equipo">
                        <?php
                           
                        ?>
                    </select>
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
