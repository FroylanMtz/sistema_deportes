<?php
require_once('conexion.php');

class Datos extends Conexion{

    //Funcion que compara si existe el usuario que intenta logearse, pasandole los datos a traves de un objeto y ademas el nombre de la tabla,
    //Asi como se convierte a la contraseña con la funcion MD5 para que se compare correctamente con la almacenada en la base de datos
    public function validarUsuario($datos, $tabla){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE usuario = :usuario AND contrasena = md5(:contra) ");

        $stmt->bindParam(':usuario', $datos['usuario'], PDO::PARAM_STR);
        $stmt->bindParam(':contra', $datos['contrasena'], PDO::PARAM_STR);

        $stmt->execute();

        $r = array();

        $r = $stmt->fetch(PDO::FETCH_ASSOC);

        return $r;

    }

    public function agregarUsuarioModel($datosModel, $tabla){
        //Llama la conexión y hace la inserción de los datos y cada stmt para llenar los datos a la tabla usuarios
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,usuario,correo,contrasena) VALUES(:nombre,:usuario,:correo,md5(:contrasena)) ");
        
        $stmt->bindParam(":nombre", $datosModel["nombre_usuario"] , PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datosModel["usuario_usuario"] , PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datosModel["correo_usuario"] , PDO::PARAM_STR);
        $stmt->bindParam(":contrasena", $datosModel["contra_usuario"] , PDO::PARAM_STR);
        
        return $stmt->execute();

    }

    public function obtenerDatosDeUsuarioId($usuario_id){

        //Se prepara el query
       $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE  usuario_id = :usuario_id");

        //Se pasan los parametros de ese query
        $stmt->bindParam(":usuario_id", $usuario_id , PDO::PARAM_INT);

        //se ejecuta
        $stmt->execute();

        $r = array();

        //Se trane todos los ddatos
        $r = $stmt->FetchAll();
        
        //y finalmente se pasan al controlador para ponerlos en la vista en donde se hace la edicion de dicho registro
        return $r;

    }

    public function editarDatosUsers($datosUsuario, $tabla){

        //Se prepara el query con el comando UPDATE -> DE EDITAR, O ACTUALIZAR
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla 
                                               SET nombre = :nombre,
                                               correo = :correo,
                                               contrasena=md5(:contrasena)
                                               WHERE usuario_id = :usuario_id ");
        
        //Se relacionan todos los parametros con los pasados en el arreglo asociativo desde el controlador
        $stmt->bindParam(":nombre", $datosUsuario["nombre_usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datosUsuario["correo_usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":contrasena", $datosUsuario["contra_usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_id", $datosUsuario["usuario_id"] , PDO::PARAM_INT);
        
        print_r($datosUsuario);

        //Y son ejecutados y notificados al controlador para que este les notifique a las vistas para que den un mensaje amigable al usuario
        if($stmt->execute()){
            return "success";
        }else{
            return "error";
        }

        $stmt->close();


    }

    public function traerDatosUsuarios($tabla){

        //Conexion::conectar() -> es igual a un objeto PDO el cual sirve para conectarse a la base de datos
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

        //Metodo que ejecuta el query previamente preparado
        $stmt->execute();

        //Se crea un objeto tipo array para recibir los datos
        $r = array();
        //se traen todos los datos con la funcion fetchAll
        $r = $stmt->FetchAll();
        
        //Se retornan los datos para el modelo
        return $r;
    
    }

    public function eliminarDatosUsuario($usuario_id, $tabla){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE usuario_id = :usuario_id ");

        $stmt->bindParam(":usuario_id", $usuario_id , PDO::PARAM_INT);

        //Le informa al controlador si se realizao con exito o no dicha transaccion
        if($stmt->execute() ){
            return "success";
        }else{
            return "error";
        }

    }

    
    public function traerDatosJugadores(){

        //Es la union de las tablas alumnos, carreras y tutores
        $stmt = Conexion::conectar()->prepare("SELECT * FROM jugadores");

        $stmt->execute();

        $r = array();

        //Se guardan todos los datos en el arreglo antes creado
        $r = $stmt->FetchAll();
        
        //Se retornan al controlador para luego ser aventadas a la vista xD
        return $r;

    }



    # JUGADORES - EQUIPO ---------------------------------------
        # ----------------------------------
    //Funcion que trae todos los registros de la tabla usuarios para mostrarlos,
    //Como todas las tablas pertenecientes a esta base de datos estan relacionados, se ocupo de una union de las mismas, para de esta forma mandar todo como si fuera una unica tabla con la informacion necesaria por la tabla principal que es de alumnos, por ejemplo digamos que se relacion la tabla alumnos con la re tutores, pero solo es por un id, para poder ver el nombre del tutor es necesario esta union
    public function traerDatosEquipoJugador(){

        //Es la union de las tablas usuarios, equipos y equipo_jugador
        $stmt = Conexion::conectar()->prepare("SELECT t2.matricula, t3.nombre as equipo , t4.nombre as deporte FROM equipo_jugadores AS t1 INNER JOIN jugadores AS t2 ON t2.matricula = t1.jugador_id INNER JOIN equipos AS t3 ON t3.equipo_id = t1.equipo_id INNER JOIN deportes AS t4 ON t4.deporte_id = t3.deporte_id");

        $stmt->execute();

        $r = array();

        //Se guardan todos los datos en el arreglo antes creado
        $r = $stmt->FetchAll();
        
        //Se retornan al controlador para luego ser aventadas a la vista xD
        return $r;
    }

    
    // Método que trae los datos de todos los jugadores de un equipo
    public function obtenerJugadoresEquipo($equipo_id) {
        // Consulta sql
        // Se seleccionan los jugadores que pertenezcana a determinado equipo
        $sql = "SELECT * FROM jugadores INNER JOIN equipo_jugadores on equipo_jugadores.equipo_id=? AND jugadores.matricula=equipo_jugadores.jugador_id";
        // Se prepara la consulta
        $stmt = Conexion::conectar()->prepare($sql);
        // Se ejcuta la consulta
        $stmt->execute([$equipo_id]);

        // Se guarda el resultado en forma de array asociativo
        $respuesta = $stmt->fetchAll();

        //var_dump($respuesta);
        //exit();
        // Se retorna el array
        return $respuesta;
    }


    //Funcion que envia al controlador todos los datos de la tabla equipos, la cual contiene las equipos de la universdiad
    public function traerDatosEquipos($tabla){

        //Conexion::conectar() -> es igual a un objeto PDO el cual sirve para conectarse a la base de datos.
        // Se ordenan los equipos por deporte
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY deporte_id");

        //Metodo que ejecuta el query previamente preparado
        $stmt->execute();

        //Se crea un objeto tipo array para recibir los datos
        $r = array();
        //se traen todos los datos con la funcion fetchAll
        $r = $stmt->FetchAll();
        
        //Se retornan los datos para el modelos        
        return $r;
    
    }

    //Funcion que almacena todos los datos de un jugador en su respectiva tabla, tabmien pasada por parametro (el nombre)
    public function guardarDatosJugador($datosJugador, $tabla){

        //Se prepara el query con el comando INSERT -> DE INSERTAR 
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(matricula, nombre, apellido, correo, foto) VALUES( :matricula, :nombre, :apellido, :correo, :foto )");
        
        //Se colocan todos sus parametros especificados, y se relacionan con los datos pasdaos por parametro a esta funcion desde el controladro en modo de array asociativo
        //Asi como se especifica como deben ser tratados (tipo de dato)
        $stmt->bindParam(":matricula", $datosJugador["matricula"] , PDO::PARAM_STR);
        $stmt->bindParam(":nombre", $datosJugador["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datosJugador["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datosJugador["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datosJugador["foto"], PDO::PARAM_STR);

        //print_r($datosJugador);

        

        //Se ejecuta dicha insercion y se notifica al controlador para que este le notifique a las vistas necesarias
        if($stmt->execute()){
            
            return "success";
        }else{
            return "error";
        }
    }

    
    //Funcion que elimina un registro pasandole la matricula para identificarlo asi como la tabla donde se encuentra ese registro
    public function eliminarDatosJugador($matricula, $tabla){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE matricula = :matricula ");

        $stmt->bindParam(":matricula", $matricula , PDO::PARAM_STR);

        //Le informa al controlador si se realizao con exito o no dicha transaccion
        if($stmt->execute() ){
            return "success";
        }else{
            return "error";
        }

    }


    //Funcion que retorna solo los datos de un jugador
    public function traerDatosJugador($matricula){

        //Se prepara el query
        $stmt = Conexion::conectar()->prepare("SELECT * FROM jugadores WHERE matricula = :matricula");

        //Se pasan los parametros de ese query
        $stmt->bindParam(":matricula", $matricula , PDO::PARAM_STR);

        //se ejecuta
        $stmt->execute();

        $r = array();

        //Se trane todos los ddatos
        $r = $stmt->FetchAll();
        
        //y finalmente se pasan al controlador para ponerlos en la vista en donde se hace la edicion de dicho registro
        return $r;

    }


    //Funcion que se usa para editar un cierto registro de la tabla jugadores, Este de giual forma tiene dos parametros, uno para especificar los datos en una arreglo asociativo y otro para indicar el nombre de la tabla donde se editaran dichos datos
    public function editarDatosJugador($datosJugador, $tabla){

        //Se prepara el query con el comando UPDATE -> DE EDITAR, O ACTUALIZAR
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla 
                                               SET nombre = :nombre, apellido = :apellido, correo = :correo, foto = :foto
                                               WHERE matricula = :matricula ");
        
        //Se relacionan todos los parametros con los pasados en el arreglo asociativo desde el controlador
        $stmt->bindParam(":nombre", $datosJugador["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datosJugador["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datosJugador["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datosJugador["foto"] , PDO::PARAM_STR);
        $stmt->bindParam(":matricula", $datosJugador["matricula"] , PDO::PARAM_STR);
        
        print_r($datosAlumno);

        //Y son ejecutados y notificados al controlador para que este les notifique a las vistas para que den un mensaje amigable al usuario
        if($stmt->execute()){
            return "success";
        }else{
            return "error";
        }



    }
    

    # JUGADORES - EQUIPOS -------------------------------------
        # ---------------------------

    //Funcion que se usa para hacer la relacion del jugador a un determinado equipo, es una tabla mucho a muchos entre equipos y jugadores
    function guardar_jugador_equipo($equipo,$jugador,$tabla){


        $stmt2 = Conexion::conectar()->prepare("SELECT t1.equipo_id as jugador, t2.nombre as equipo, t3.nombre as deporte FROM equipo_jugadores AS t1 INNER JOIN equipos AS t2 ON t2.equipo_id = t1.equipo_id  INNER JOIN deportes AS t3 ON t3.deporte_id = t2.deporte_id WHERE jugador_id = :jugador");

        $stmt2->bindParam(':jugador', $jugador, PDO::PARAM_STR);
        $stmt2->execute();
        $datosEquiposJugador = array();
        $datosEquiposJugador = $stmt2->FetchAll();


        $stmt3 = Conexion::conectar()->prepare("SELECT t1.nombre as equipo, t2.nombre as deporte FROM equipos AS t1 INNER JOIN deportes as t2 ON t2.deporte_id = t1.deporte_id WHERE t1.equipo_id = :equipo");

        $stmt3->bindParam(':equipo', $equipo, PDO::PARAM_INT);
        $stmt3->execute();
        $deporteEquipo = array();
        $deporteEquipo = $stmt3->FetchAll();

        $sonDelMismoDeporte = false;

        for($i=0; $i < count($datosEquiposJugador); $i++ ){

            if( $datosEquiposJugador[$i]['deporte'] == $deporteEquipo[0]['deporte'] ){
                $sonDelMismoDeporte = true;
            }

        }

        if($sonDelMismoDeporte){
            echo '<script> alert("El jugador que quiere enrolar a ese equipo ya tiene un equipo asociado en el mismo deporte") </script> ';
        }else{

            //Se prepara el query con el comando INSERT -> DE INSERTAR 
            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(equipo_id, jugador_id) VALUES(:equipo, :jugador) ");
            
            //Se colocan todos sus parametros especificados, y se relacionan con los datos pasdaos por parametro a esta funcion desde el controladro en modo de array asociativo
            //Asi como se especifica como deben ser tratados (tipo de dato)
            $stmt->bindParam(':equipo', $equipo , PDO::PARAM_INT);
            $stmt->bindParam(":jugador", $jugador , PDO::PARAM_STR);


            //Se ejecuta dicha insercion y se notifica al controlador para que este le notifique a las vistas necesarias
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
        }
    }


    // Método para obtener los equipos a los que pertenece un jugador
    // Se pasa como parámetro la matrícula del jugador
    public function equiposDeJugador($matricula) {
        // Consulta sql, inner join de las tablas equipo_jugador y equipos para traer los
        // datos de los equipos a los que pertenece cierto jugador
        $sql = "SELECT * FROM equipos INNER JOIN equipo_jugadores ON equipo_jugadores.jugador_id=? AND equipos.equipo_id = equipo_jugadores.equipo_id";
        // Se prepara la consulta
        $stmt = Conexion::conectar()->prepare($sql);
        // Se ejcuta la consulta pasandole la matricula del jugador como parámetro
        $stmt->execute([$matricula]);

        // Se guarda el resultado en forma de array asociativo
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Se retorna la respuesta
        return $respuesta;
    }


    // Método para dar de baja un jugador de un equipo
    // Recibe como parámetros el id del equipo y la matricula del jugador
    public function bajaJugadorEquipo($equipo_id, $jugador_id) {
        // Consulta sql, se elimina el registro en donde coincidan los dos valores
        // de los parámetros de la tabla equipo_jugadores
        $sql = "DELETE FROM equipo_jugadores WHERE equipo_id=? AND jugador_id=?";
        // Se prepara la consulta
        $stmt = Conexion::conectar()->prepare($sql);

        // Si se ejecuta con éxito devuelve success de lo contrario false
        // Se pasan los parámetros de la función en execute([])
        if($stmt->execute([$equipo_id,$jugador_id])){ return "success"; }
        else return false;
    }

    # DEPORTES -----------------------------------------
        # -------------------------------
    // Método para obtener el nombre del deporte por el id
    // Recibe como parámetro el id del deporte
    public function obtenerDeportePorId($deporte_id){
        // Consulta sql, selecciona el nombre dependiendo del id
        $sql = "SELECT nombre FROM deportes WHERE deporte_id=?";
        // Se prepara la consulta con el método prepare
        $stmt = Conexion::conectar()->prepare($sql);
        // Se ejecuta la consulta, pasándole el parámetro del deporte_id
        $stmt->execute([$deporte_id]);

        // Se obtiene el resultado en forma de array
        $respuesta = $stmt->fetch();

        // Se retorna el array
        return $respuesta;
    }

    // Método para obtener los datos de los deportes
    public function obtenerDatosDeportes(){
        // Consulta sql
        $sql = "SELECT * FROM deportes";
        // Se prepara la consulta
        $stmt = Conexion::conectar()->prepare($sql);
        // Se ejecuta la consulta
        $stmt->execute();

        // Se obtiene el resultado en forma de array
        $respuesta = $stmt->fetchAll();
        // Se retorna el array
        return $respuesta;
    }



    # EQUIPOS -----------------------------------------
        # -----------------------------
      //Funcion que almacena todos los datos de un equipo en su respectiva tabla, también pasada por parametro (el nombre)
    public function agregarNuevoEquipo($nombreEquipo, $nombreDeporte){

        # ID del deporte --------------------------------
        // Se obtiene el id del deporte
        $sql_deporte_id = "SELECT deporte_id FROM deportes WHERE nombre=?";
        $stmt_deporte_id = Conexion::conectar()->prepare($sql_deporte_id);
        $stmt_deporte_id->execute([$nombreDeporte]);
        $deporte_id = $stmt_deporte_id->fetch();


        //Se prepara el query con el comando INSERT -> DE INSERTAR 
        $stmt = Conexion::conectar()->prepare("INSERT INTO equipos(nombre,deporte_id) VALUES( :nombre, :deporte)");
        
        //Se colocan todos sus parametros especificados, y se relacionan con los datos pasdaos por parametro a esta funcion desde el controladro en modo de array asociativo
        //Asi como se especifica como deben ser tratados (tipo de dato)
        
        $stmt->bindParam(":nombre", $nombreEquipo, PDO::PARAM_STR);
        $stmt->bindParam(":deporte", $deporte_id["deporte_id"], PDO::PARAM_STR);
        

        //Se ejecuta dicha insercion y se notifica al controlador para que este le notifique a las vistas necesarias
        if($stmt->execute()){
            
            return "success";
        }else{
            return "error";
        }
    }

    // Método para editar un equipo, se pasan como parámetros el nombre del equipo,
    // nombre del deporte y el id del equipo
    public function editarEquipo($nombreEquipo, $nombreDeporte, $equipo_id){

        # ID del deporte --------------------------------
        // Se obtiene el id del deporte
        $sql_deporte_id = "SELECT deporte_id FROM deportes WHERE nombre=?";
        $stmt_deporte_id = Conexion::conectar()->prepare($sql_deporte_id);
        $stmt_deporte_id->execute([$nombreDeporte]);
        $deporte_id = $stmt_deporte_id->fetch();


        //Se prepara el query con el comando INSERT -> DE INSERTAR 
        $stmt = Conexion::conectar()->prepare("UPDATE equipos SET nombre=?, deporte_id=? WHERE equipo_id=?");
                
        //Se ejecuta dicha insercion y se notifica al controlador para que este le notifique a las vistas necesarias
        if($stmt->execute([$nombreEquipo,$deporte_id["deporte_id"],$equipo_id])) {
            return "success";
        }else{
            return "error";
        }
    }


    // Método para eliminar un equipo, se pasa de parámetro el id del equipo
    public function eliminarEquipo($equipo_id){
        // Consulta sql
        $sql = "DELETE FROM equipos WHERE equipo_id=?";
        // Se prepara la consulta
        $stmt = Conexion::conectar()->prepare($sql);
        // Se ejecuta y se verifica si se eliminó el equipo de forma exitosa
        if($stmt->execute([$equipo_id])){ return "success"; }
        else{ return false; }
    }


    // Método para obtener los datos de un equipo (para poder actualizarlo)
    // Recibe como parámetro el id traido con GET
    public function obtenerUnEquipo($equipo_id){
        // Consulta sql
        $sql = "SELECT * FROM equipos WHERE equipo_id=?";
        // Se prepara la consulta
        $stmt = Conexion::conectar()->prepare($sql);
        // Se ejecuta la consulta pasándole como parámetro el id del equipo
        $stmt->execute([$equipo_id]);

        // Se obtiene el resultado de la consulta como un array asociativo
        $respuesta = $stmt->fetch();

        // Se retorna el array
        return $respuesta;
    }


}

?>