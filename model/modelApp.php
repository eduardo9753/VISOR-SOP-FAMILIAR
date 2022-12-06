<?php

include_once('config/conexionOracle.php');
include_once('config/conexionMysql.php');

class ModeloApp
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



    /*******************************************DATA PACIENTE WEB SERVICE********************************************/
    public function verPacienteEstadoActual(Paciente $paciente)
    {
        try {
            $sql = "SELECT * FROM TIEMPO_SOP SOP WHERE SOP.DOCUMENTO =?";
            $stm = $this->MYSQL->ConectarBD()->prepare($sql);
            $stm->execute(array($paciente->getDOCUMENTO()));
            return $stm->fetchAll(PDO::FETCH_OBJ);  //CON fetchAll ME RETORNA -> [{}] SE USA ESTE YA QUE EN EL ANDROID
                                                    //LO ESTAMOS RECORRIENDO CON BUCLE for()     
        } catch (Exception $th) {                   //CON fecth ME RETORNA -> {}
            echo $th->getMessage();
        }
    }
}
