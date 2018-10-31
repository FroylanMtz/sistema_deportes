<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
            <img src="Public/img/user.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
            <?php
                echo '<p>'.$_SESSION['nombre'].'</p>';
                echo '<a href="#"> Admin </a>';
            ?>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <!--ENCABEZADO-->
            <li class="header"> <center> <strong> ADMINISTRACION </strong> </center> </li>


            <!--OPCION DE JUGADORES -->

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Jugadores</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>

                <ul class="treeview-menu">
                    <li>
                        <a href="index.php?action=jugadores">
                            
                            <i class="fas fa-list-ol"></i> Lista de jugadores
                        </a>
                    </li>
                    <li active>
                        <a href="index.php?action=agregar_jugador">
                            <i class="fas fa-user-plus"></i> Agregar jugador
                        </a>
                    </li>
                </ul>

            </li>

            <!--OPCION DE EQUIPOS -->
            <li class="treeview">
                <a href="#">
                    <i class="fas fa-graduation-cap"> </i> 
                    <span>Equipos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="index.php?action=agregar_jugador_a_equipo">
                            <i class="fas fa-plus-square"></i> Agregar jugador a equipo
                        </a>
                    </li>

                    <li>
                        <a href="index.php?action=equipos">
                            
                            <i class="fas fa-list-ol"></i> Lista de equipos
                        </a>
                    </li>

                    <li>
                        <a href="index.php?action=agregar_equipo">
                            <i class="fas fa-plus-square"></i> Agregar equipo
                        </a>
                    </li>
                </ul>
            </li>
            
            <!--OPCION DE USUARIOS-->
            <li class="treeview">
                <a href="#">
                    <i class="fas fa-users"></i>
                    <span>Usuarios</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="index.php?action=usuarios">
                            
                            <i class="fas fa-list-ol"></i> Lista de usuarios
                        </a>
                    </li>
                    <li>
                    <a href="index.php?action=agregar_usuario">
                            <i class="fas fa-plus-square"></i> Agregar usuario
                        </a>
                    </li>


                    
                </ul>
            </li>
            
        </ul>
    </section>
</aside>