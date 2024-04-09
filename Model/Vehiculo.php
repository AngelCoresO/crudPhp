<?php
require_once "Conexion.php";

class Vehiculo{
    private $conn;
    public $id;
    public $marca;
    public $color;
    public $kilometros;

    public function __construct(){
        $db=new Conexion();
        $this->conn=$db->getConexion();
    }

    public function listar(){
        $sql= "SELECT * FROM vehiculos";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $datos;
    }

    public function crear($marca,$color,$kilometros){
        $sql= "INSERT INTO vehiculos (marca,color,kilometros) values('$marca','$color','$kilometros')";
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
        $sql= "SELECT * FROM vehiculos WHERE id=$id";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }

    public function eliminar($id){
        if($this->leer($id)){
            $sql= "DELETE FROM vehiculos WHERE id=$id";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute()){
                echo "Eliminado correctamente.";
                return true;
            }else{
                echo "No eliminado.";
                return false;
            }
        }else{
            echo "No existe el vehiculo con id = $id";
            return false;
        }
    }

    public function actualizar($id,$marca,$color,$kilometros){
        if($this->leer($id)){
            $sql= "UPDATE vehiculos SET marca='$marca',color='$color',kilometros='$kilometros' WHERE id=$id";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute()){
                echo "Actualizado correctamente.";
                return true;
            }else{
                echo "No actualizado.";
                return false;
            }
        }else{
            echo "No existe el vehiculo con id = $id";
            return false;
        }
    }
}

$marca="Toyota";
$color="Negro";
$kilometros=40000;
$v=new Vehiculo();

var_dump($v->leer(2));
var_dump($v->leer(3)['color']);

var_dump($v->crear($marca,$color,$kilometros));

?>