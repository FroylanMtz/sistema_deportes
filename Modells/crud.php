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

    //Funcion que trae todos los registros de la tabla alumnos para mostrarlos,
    //Como todas las tablas pertenecientes a esta base de datos estan relacionados, se ocupo de una union de las mismas, para de esta forma mandar todo como si fuera una unica tabla con la informacion necesaria por la tabla principal que es de alumnos, por ejemplo digamos que se relacion la tabla alumnos con la re tutores, pero solo es por un id, para poder ver el nombre del tutor es necesario esta union
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

    public function traerDatosEquipoJugador(){

        //Es la union de las tablas alumnos, carreras y tutores
        $stmt = Conexion::conectar()->prepare("SELECT t2.matricula, t3.nombre as equipo , t4.nombre as deporte FROM equipo_jugadores AS t1 INNER JOIN jugadores AS t2 ON t2.matricula = t1.jugador_id INNER JOIN equipos AS t3 ON t3.equipo_id = t1.equipo_id INNER JOIN deportes AS t4 ON t4.deporte_id = t3.deporte_id");

        $stmt->execute();

        $r = array();

        //Se guardan todos los datos en el arreglo antes creado
        $r = $stmt->FetchAll();
        
        //Se retornan al controlador para luego ser aventadas a la vista xD
        return $r;

    }

    //Funcion que envia al controlador todos los datos de la tabla carreras, la cual contiene las carreras de la universdiad
    public function traerDatosEquipos($tabla){

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

    //Funcion que almacena todos los datos de un alumno en su respectiva tabla, tabmien pasada por parametro (el nombre)
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
            

            /*$stmt = Conexion::conectar()->prepare("INSERT INTO equipo_jugadores(equipo_id, jugador_id) VALUES(:equipo, :jugador) ");
        
            $stmt->bindParam(':equipo', $datosJugador['equipo'] , PDO::PARAM_INT);
            $stmt->bindParam(':jugador', $datosJugador['matricula'] , PDO::PARAM_STR);

            $stmt->execute();*/


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


    //Funcion que retorna solo los datos de un alumno, esta de igual forma utiliza la union de las tres tablas para mostrar toda la informacion del usuario de uan mejor forma, la diferencia es que a esta se le pasa un parametro para identificiar el registro que se quiere, que en este caso pra identificarlo se hace uso del id que es la matricula
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


    //Funcion que se usa para editar un cierto registro de la tabla alumnos, Este de giual forma tiene dos parametros, uno para especificar los datos en una arreglo asociativo y otro para indicar el nombre de la tabla donde se editaran dichos datos
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
    

    function guardar_jugador_equipo($equipo,$jugador,$tabla){


        $stmt2 = Conexion::conectar()->prepare("SELECT * FROM equipo_jugadores WHERE jugador_id = :jugador");

        $stmt2->bindParam(':jugador', $jugador, PDO::PARAM_STR);

        //se ejecuta
        $stmt2->execute();

        //
        $datos = array();

        //Se trane todos los ddatos
        $datos = $stmt->FetchAll();




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

?>