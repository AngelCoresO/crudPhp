<?php
require_once "Conexion.php";

class Usuario{
    private $conn;
    public $id;
    public $nombre;
    public $dni;
    public $vehiculoId;

    public function __construct(){
        $db=new Conexion();
        $this->conn=$db->getConexion();
    }

    public function listar(){
        $sql= "SELECT * FROM usuarios";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $datos;
    }

    public function crear($nombre,$dni,$vehiculo_id){
        $sql= "INSERT INTO usuarios (nombre,dni,vehiculo_id) values('$nombre','$dni','$vehiculo_id')";
        $stmt=$this->conn->prepare($sql);
        if($stmt->execute()){
            echo "Creado correctamente.";
            return true;
        }else{
            echo "No se ha podido crear.";
            return false;
        }
    }

    public function leer($id){
        $sql= "SELECT * FROM usuarios WHERE id=$id";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }

    public function eliminar($id){
        if($this->leer($id)){
            $sql= "DELETE FROM usuarios WHERE id=$id";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute()){
                echo "Eliminado correctamente.";
                return true;
            }else{
                echo "No eliminado.";
                return false;
            }
        }else{
            echo "No existe el usuario con id = $id";
            return false;
        }
    }

    public function actualizar($id,$nombre,$dni,$vehiculo_id){
        if($this->leer($id)){
            $sql= "UPDATE usuarios SET nombre='$nombre',dni='$dni',vehiculo_id='$vehiculo_id' WHERE id=$id";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute()){
                echo "Actualizado correctamente.";
                return true;
            }else{
                echo "No actualizado.";
                return false;
            }
        }else{
            echo "No existe el usuario con id = $id";
            return false;
        }
    }

    /*por la estructura de la base de datos, un usuario solo puede tener un vehiculo asociado, pero un vehiculo puede pertenecer a varios usuarios,
    hay un metodo en vehiculo para ver todos los usuarios que lo poseen.*/
    public function vehiculosUsuario($id){
        if($this->leer($id)){
            $sql= "SELECT v.* FROM usuarios u,vehiculos v WHERE u.id=$id AND u.vehiculo_id=v.id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        }else{
            echo "No existe el usuario con id = $id";
            return false;
        }
    }
}

$nombre="Francisco";
$dni="1234566A";
$vehiculo_id=2;
$u=new Usuario();
var_dump($u->leer(2));
var_dump($u->leer(3)['dni']);

var_dump($u->vehiculosUsuario(4));

?>