<?php

include 'conexion.php';

class Paciente{
    private $id;
    private $sip;
    private $dni;
    private $nombre;
    private $apellido1;
    private $pdo;
    private static final $TABLE_NAME = 'pacientes';


    function __construct($id=null, $sip=null, $dni=null, $nombre=null, $apellido1=null){
        $this-> id = $id;
        $this-> sip = $sip;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
    }

    public static function find($filters=[], $pagina=0, $num_registros=10){
        try{
            $pdo = BDConnectionSingleton::getInstance();

            $sql = 'select * FROM pacientes where true';
            $params = [];
            if(isset($filters["id"])) {
                $sql.=" and id like :id";
                $params[":id"]="%".$filters["id"]."%";
            }
            if(isset($filters["nombre"])) {
                $sql.=" and nombre like :nombre";
                $params[":nombre"]="%".$filters["nombre"]."%";
            }
            $sql.=" limit 0, 10";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            $pacientes = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $row=null;
            $stmt=null;
            $pdo = null;

            return $pacientes;
        } catch (PDOException $p){
            throw $p;
        }
    }

    public function delete() {
        try {
            $pdo = BDConnectionSingleton::getInstance();

            $sql = 'DELETE FROM ' . self::$TABLE_NAME . 'WHERE id = :id';
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (PDOException $p) {
            throw $p;
        }
    }

    public function insert() {
        try{
            $pdo = BDConnectionSingleton::getInstance();

            $sql = 'INSERT INTO ' . self::$TABLE_NAME . ' (id,sip, dni, nombre, apellido1) VALUES (:id,:sip, :dni, :nombre, :apellido1)';
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':sip', $this->sip);
            $stmt->bindParam(':dni', $this->dni);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellido1', $this->apellido1);
            
            $stmt->execute();
        } catch (PDOException $p) {
            throw $p;
        }
    }

    public function editar(){
        try {
            $pdo = BDConnectionSingleton::getInstance();
            $sql = 'UPDATE ' . self::$TABLE_NAME . ' SET sip = :sip, dni = :dni, nombre = :nombre, apellido1 = :apellido1 WHERE id = :id';
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':sip', $this->sip);
            $stmt->bindParam(':dni', $this->dni);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellido1', $this->apellido1);
    
            $stmt->execute();
        } catch (PDOException $p) {
            throw $p;
        }
    }

}

