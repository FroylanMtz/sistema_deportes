<?php

class Controlador
{

    private $enlace = '';
    private $pagina = '';

    //Llamar a la plantilla
    public function cargarPlantilla()
    {
        session_start();
        //Include se utiliza para invocar el arhivo que contiene el codigo HTML
        
        if( isset($_SESSION['iniciada']) ){
            include 'Views/plantilla.php';
        }else{
            include 'login.php';
        }
        
    }

    //Interacción con el usuario
    public function mostrarPagina()
    {
        //Trabajar con los enlaces de las páginas
        //Validamos si la variable "action" viene vacia, es decir cuando se abre la pagina por primera vez se debe cargar la vista index.php

        if(isset($_GET['action'])){
            //guardar el valor de la variable action en views/modules/navegacion.php en el cual se recibe mediante el metodo get esa variable
            $enlace = $_GET['action'];
        }else{
            $enlace = 'jugadores';
        }

        //Mostrar los archivos de los enlaces de cada una de las secciones: inicio, nosotros, etc.
        //Para esto hay que mandar al modelo para que haga dicho proceso y muestre la informacions

        $pagina = Modelo::mostrarPagina($enlace);

        include $pagina;
    }

    //Funcion para acceder al sistema, en la pagina de login es donde se llama a esta funcion, en esa pagina esta un formulario en el cual se envian los datos que son comparados en la base de datos para saber si el usuario que intenta ingresar si está en la base de datos y dejarlo entrar
    public function iniciarSesion()
    {
        //Compara si se envia algo en los campos del formulario, sino no compara nada y regresa a la misma pagina
        if( isset($_POST['usuario']) && isset( $_POST['contrasena'] ) )
        {

            //Los datos de los campos del formulario los almacena en un arreglo asociativo para enviarlos a la funcion del modulo para poder realizar la consulta a la base de datos a partir de estos
            $datos = array( 'usuario'      => $_POST['usuario'],
                            'contrasena'  => $_POST['contrasena'] );
            
            
            //Se envian a traves de la funcion validar usuario, y se regresa una respuesta para saber si existen esos datos en la bases de datos
            $respuesta = Datos::validarUsuario($datos, 'usuarios');
            
            //Compara si hay datos coincidentes sino manda un mensajito de que estan equivocadas el usuario o el correo
            if( $respuesta )
            {
                //Una vez que se comparó en la base de datos y efectivamente esta el usuario que trata de ingresar se inicia la sesion, y se crean algunas variables de sesion para informacion en la pagina, como el nombre del usuario actualmente logeado y el id del mismo 
                session_start();
                $_SESSION['iniciada'] = true;
                $_SESSION['nombre'] = $respuesta['nombre'];
                $_SESSION['idUsuario'] = $respuesta['usuario_id'];


                //despues de que almacena los datos en la sesion, redirige el flujo de la pagina a la pagina principal dentro del sistema
                echo '<script> window.location.href = "index.php?action=jugadores"; </script>';
            }else
            {
                //Si no existen los datos pasados por el usuario a la comparacion con la base de datos, la pagina manda una alerta avisandole de esto y se redirecciona a la misma pagina de incio de sesion
                echo '<script> alert("Usuario o contraseña incorrectos") </script>';
                echo '<script> window.location.href = "login.php"; </script>';
            }

        }
        
    }

    //Funcion que se encarga de registrar un nuevo usuario a la tabla de usuarios, los cuales son los administradores que pueden ingresar al sistema
    public function agregarUsuario(){

        //compara que el forumlario de registro no venga vacio
        if(isset($_POST['nombre'])){

            //Guarda en variables los datos que vienen desde el formulario de registro
            $nombre_usuario  = $_POST['nombre'];
            $usuario_usuario = $_POST['usuario'];
            $correo_usuario  = $_POST['correo'];
            $contra_usuario  = $_POST['contra'];

            //Y estas variables se almacenan en una arreglo asociativo
            $datos=array('nombre_usuario'=>$nombre_usuario,
                         'usuario_usuario'=>$usuario_usuario,
                         'correo_usuario'=>$correo_usuario,
                         'contra_usuario'=>$contra_usuario);
            
            //Que se le pasa a la funcion del modelo que se encarga de almacenar estos datos en su respectiva tabla en la base de datos, a la funcion se le pasan por parametro dos datos, el arreglo de la informacion y el nombre de la tabla
            $respuesta = Datos::agregarUsuarioModel($datos, 'usuarios');

        }

    }

    //funcion que retorna una arreglo asociativo con todos los usuarios registrados en la base de datos
    public function obtenerDatosUsuarios()
    {

        //Se declara un arreglo en donde será almacenada la informacion
        $datosDeUsuarios = array();
        
        //Manda llamar el metodo desde el modelo y pasandole la tabla de donde se van a extraer los datos como parametro
        $datosDeUsuarios = Datos::traerDatosUsuarios("usuarios");

        return $datosDeUsuarios; //regresa los datos extraidos de la tabla a la vista donde se muestran los usuadios registrados en un datatable
    }


    //Funcion que extra los datos de un unico usuario desde la base de datos, para saber cual registro trae se le pasa el identificador del usuario
    public function obtenerDatosUsuarioId(){
        $usuario_id = $_GET['id'];

        $datosDeUsuarios = array();
        
        //Se manda llamar el metodo del modelo pasandole como parametro el identificador del usuario a traer los datos
        $datosDeUsuarios = Datos::obtenerDatosDeUsuarioId($usuario_id);

        return $datosDeUsuarios; //Se retornan los datos a la vista donde se modificaran los datos de ese usuario
    }

    //funcion para editar datos de usuarios existentes en la tabla    
    public function editarDatosUser(){

        //se guardan los datos que se traen desde el formulario en el cual se llenan con datos que estan en la db
        $usuario_id = $_GET['id'];
        $nombre_usuario=$_POST['nombre'];
        $correo_usuario=$_POST['correo'];
        $contra_usuario=$_POST['contra'];

        //Estos datos se almacenan en un arreglo asociativo
        $datosUsuario=array('usuario_id'=>$usuario_id,
                         'nombre_usuario'=>$nombre_usuario,
                         'correo_usuario'=>$correo_usuario,
                         'contra_usuario'=>$contra_usuario);
        
        
        //Se finaliza de crear los datos, ya con la  foto nueva o en caso de que haya elegido una nueva
        //Se manda ese objeto con los datos al modelo para que los almacenen en la tabla pasada por parametro aqui abajo
        $respuesta = Datos::editarDatosUsers($datosUsuario, "usuarios");
        
        //El metodo responde con un success o un error y se realiza las notificaciones pertinentes al usuario
        if($respuesta == "success"){
            
            echo '<script> 
                    alert("Datos guardados correctamente");
                    window.location.href = "index.php?action=usuarios"; 
                  </script>';
            
        }else{
            echo '<script> alert("Error al guardar") </script>';
        }

    }

    //Funcion que elimina un usuario desde la vista donde se muestran todos
    public function eliminarUsuario(){

        //Para saber que usario eliminar se identifica con su id, en este caso la matricula
        $usuario_id = $_GET['id'];
        
        //Se manda llamar esta funcion desde el modelo en la cual se le pasa el id del jugador a eliminar asi como la tabla en donde se encuentra
        $respuesta = Datos::eliminarDatosUsuario($usuario_id, "usuarios");

        //Se notifca al usuario como se realizo en los metodos pasados y si se borro exitosamente lo redirecciona a la pagina principal en donde estan listados todos los usuarios
        if($respuesta == "success"){
            echo '<script> 
                    alert("Usuario eliminado");
                    window.location.href = "index.php?action=usuarios";
                  </script>';
        }else{
            echo '<script> alert("Error al eliminar") </script>';
        }

    }

    //Funcion que trae a todos los jugadores registrados en la dicha tabla para mostrarlos en la pagina de jugadores.php, se muestra ademas un boton para actualizar y eliminar para administrarlos
    public function obtenerDatosJugadores()
    {
        $datosDeJugadores = array();
        
        //Esta funcion del modelo no pide la tabla ya que se trata de una union de todas las tres tablas existentes para traer todos los datos completos y entendibles
        $datosDeJugadores = Datos::traerDatosJugadores();

        return $datosDeJugadores;
    }

    //Funcion que se encarga de traer los datos de UN solo jugador especificado por la variable GET[id]
    public function traerDatosEquipoJugador(){

        //Se declara un arreglo para almacenar los datos que responde el modelo
        $datosEquipoJugadores = array();
        
        //Ese arreglo es llenado con todos los datos
        $datosEquipoJugadores = Datos::traerDatosEquipoJugador();

        //Se regresan los datos a la vista para la posterior edicion
        return $datosEquipoJugadores;

    }

    //Funcion que se manda llamar al registrar un jugador nuevo a la aplicacion, todos los datos son enviados a traves de un formulario el cual esta funcion cacha con los parametros POST identificandolos con el respectivo nombre de campo de la vista agregar_alumno.php
    public function guardarDatosJugador(){
        
        //Datos recibidos de la vista, necesarios para identificar al usuario
        $matricula = $_POST['matricula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        

        //Para saber el nombre de la foto se manda llamar esta funcion
        $nombreArchivo = basename($_FILES['foto']['name']);
        
        //Se concatena al nombre la carpeta en donde se guardaran todas las fotos cargadas por los usuarios
        $directorio = 'fotos_jugadores/' . $nombreArchivo;

        //Para hacer algunas validaciones y el usuario por ejemplo no pase como foto una archivo pdf se extrae la extencion de la foto
        $extension = pathinfo($directorio , PATHINFO_EXTENSION);

        //Todos los datos obtenidos del formulario son guardados en un objeto para luego ser pasados al modelo en donde serna almacenados en su respectiva tabla
        $datosJugador = array('matricula' => $matricula,
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'correo' => $correo,
                            'foto' => $matricula.'.'.$extension ); //El nombre de la foto de cada uusario sera el nombre de su matricula, para de esta forma llevar un control y que las fotos no se repiten y se sobreescriban


        //Aqui es donde se hace la validacion de el archivo sea una foto con extensiones de imagenes frecuentes y no un formato .docs o un pdf por ejemplo
        if($extension != 'png' && $extension != 'jpg' && $extension != 'PNG' && $extension != 'JPG'){
            echo '<script> alert("Error al subir el archivo intenta con otro") </sript>';
        }else{

            //Una vez que se ha cargado la imagen a los archivos temporales de php, esta funcion la mueve de ahi y la coloca en la direccion donde se guardaran las fotos ya con el nombre presonalizado por cada usuario, que es su matricula
            move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos_jugadores/'.$matricula . '.' . $extension);

            //Despues de que se ha guardado la imagen en la carpeta, se manda llamar la funcion del modelo en la cual se pasan el objeto con los datos del formulario para ser guardado
            $respuesta = Datos::guardarDatosJugador($datosJugador, "jugadores");

            //Se recibe la respuesta del metodo y si esta es exitosa se manda un mensaje de notificacion al cliente y se reenvia al usuario a la lista de todos los usuarios para que vea la insercion del nuevo alumno.
            if($respuesta == "success"){
                echo '<script> 
                            alert("Datos guardados correctamente");
                            window.location.href = "index.php?action=jugadores"; 
                      </script>';
                //header('index.php?action=alumnos');
            }else{
                //En caso de haber un error se queda en la misma pagina y le notifica al ususario
                echo '<script> alert("Error al guardar") </script>';
            }
        }
    }

    //Funcion que retorna a la vista de registro los datos de las carreras disponibles para ponerlos en una lista seleccionable
    public function obtenerDatosEquipos()
    {

        $datosDeEquipos = array();
        
        //Manda llamar el metodo desde el modelo y pasandole la tabla de donde se van a extraer los datos como parametro
        $datosDeEquipos = Datos::traerDatosEquipos("equipos");

        return $datosDeEquipos;
    }

    //Funcion que sirve para eliminar los datos de un jugador de la tabla, para saber que jugador a eliminar se pasa como parametro GET la matricula del alumno, y posterioremte se pasa como parametro junto con el nombre de la tabla para que el modelo haga el resto
    public function eliminarJugador(){

        $matricula = $_GET['id'];
        
        $respuesta = Datos::eliminarDatosJugador($matricula, "jugadores");

        //Se notifca al usuario como se realizo en los metodos pasados y si se borro exitosamente lo redirecciona a la pagina principal en donde estan listados todos los usuarios
        if($respuesta == "success"){
            echo '<script> 
                    alert("Jugador eliminado correctamente");
                    window.location.href = "index.php?action=jugadores ";
                  </script>';
        }else{
            echo '<script> alert("Error al eliminar") </script>';
        }

    }

    //Funcion que trae los datos de UN solo alumno, esto con el fin de actualizarlo en la vista editar_alumno, para saber que usario se va a editar se manda un parametro GET llamado id en el cual va el id del usuario que en este caso es la matricula
    public function obtenerDatosJugador(){

        $matricula = $_GET['id'];

        $datosDeJugador = array();
        
        //Se manda llamar el metodo del modelo pasandole como parametro la matricula del usuario a traer los datos, de igual forma se hace una union de tablas para obtener la informacion mas entendible, por ello no se pasa el nombre de la tabla como parametro
        $datosDeJugador = Datos::traerDatosJugador($matricula);

        return $datosDeJugador;
    }

    //Funcion que permite editar los datos de un jugador pasandole los datos por medio de un formualrio, esta funcion es muy parecida a la de arriba a diferencia que manda a otra funcion al modelo la cual sirve para actualizar los datos de un respectivo jugador
    public function editarDatosJugador(){

        //Las variables alamcenan los datos que vienen desde el formulario en donde se editan los datos
        $matricula = $_GET['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        
        //Esta es la forma en que se almacena el nombre de la foto ademas de colocar el multipart form data 
        $nombreArchivo = basename($_FILES['foto']['name']);
        
        //direcotrio en donde se almacenara la imagen que se atualice
        $directorio = 'fotos_jugadores/' . $nombreArchivo;

        $extension = pathinfo($directorio , PATHINFO_EXTENSION);
        

        //Tambien se compara si el usuario solo quiere actualizar los datos o tambien la foto de perfil, en caso de que solo quiera editar los datos y quiera conservar la foto entra en el if de acontinuacion para almacenar el nombre de la misma foto que tenia previamente
        if($nombreArchivo == "" ){
            $foto = $_POST['fotoActual'];
        }else{
            
            if($extension != 'png' && $extension != 'jpg' && $extension != 'PNG' && $extension != 'JPG'){
                echo '<script> alert("Error al subir el archivo intenta con otro") </sript>';
                
                $foto = $_POST['fotoActual'];

            }else{

                //En caso de que el usuario haya querido ademas de actualizar sus datos en tipo texto, tambien editar la foto, entra aesta parte del if en donde crea una nueva foto, o sobreescibe la existente y la almacena en la variable foto la cual sera almacenada con los datos realizado.

                move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos_jugadores/'.$matricula . '.' . $extension);

                $foto = $matricula . '.' . $extension;

            }
        }

        //Se finaliza de crear los datos, ya con la  foto nueva o en caso de que haya elegido una nueva
        $datosJugador = array('matricula' => $matricula,
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'correo' => $correo,
                            'foto' => $foto );
        
        //Se manda ese objeto con los datos al modelo para que los almacenen en la tabla pasada por parametro aqui abajo
        $respuesta = Datos::editarDatosJugador($datosJugador, "jugadores");
        
        //El metodo responde con un success o un error y se realiza las notificaciones pertinentes al usuario
        if($respuesta == "success"){
            
            echo '<script> 
                    alert("Datos guardados correctamente");
                    window.location.href = "index.php?action=jugadores"; 
                  </script>';
            
        }else{
            echo '<script> alert("Error al guardar") </script>';
        }

    }


    //funcion que permite relacion un jugaro a un respectivo equipo, es la tabla de muchos a muchos que esta entre jugadores y equipos, debido a que un equipo puede tener muchos jugadores y un jugador puede estar en mucos equipos
    public function guardar_jugador_equipo(){

        //Datos que vienen desde el formulario en de la vista agregar_jugador_a_equipo en donde se coloca un jugador a un equipo
        $jugador = $_POST['jugador'];
        $equipo = $_POST['equipo'];

        //y se pasan al modelo desde esta funcion en la cual se le pasa el equipo y el jugador a relacionar
        $respuesta = Datos::guardar_jugador_equipo($equipo, $jugador, "equipo_jugadores");

        if($respuesta == "success"){
            
            echo '<script> 
                    alert("Datos guardados correctamente");
                    window.location.href = "index.php?action=jugadores"; 
                  </script>';
            
        }else{
            echo '<script> alert("Error al guardar") </script>';
        }

    }

}