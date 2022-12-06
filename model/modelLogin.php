<?php

include_once('config/conexionOracle.php');
include_once('config/conexionMysql.php');

class ModeloLogin
{

    public $PDO;
    public $MYSQL;

    public function __construct()
    {
        try {
            $this->PDO = new ConexionOracle(); //INICIANDO LA CONEXION A LA BD
            $this->MYSQL = new ClassConexion();
        } catch (Exception $th) {
            throw $th;
        }
    }



    /*******************************************LOGEO DEL USUARIO********************************************/
    public function logeo(Usuario $usuario)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE nombre_usuario=? AND contra_usuario=?";
            $stm = $this->MYSQL->ConectarBD()->prepare($sql);
            $stm->execute(array($usuario->getnombreUser(), $usuario->getcontraUser()));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
}
