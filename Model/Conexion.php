<?php

class Conexion{
    private $host="localhost";
    private $dbName="vehiculos_usuarios_bd";
    private $user="root";
    private $password="";
    
    public $conn;

    public function getConexion(){
        try{
            $this->conn=new PDO("mysql:host=".$this->host.";dbname=".$this->dbName,$this->user,$this->password);
        }catch(Exception $e){
            echo "Error de conexion: ".$e->getMessage();
        }
        return $this->conn;
    }
}

$c=new Conexion();
$c->getConexion();
var_dump($c->conn);
?>