<?php

//MODEL
include_once('model/modelLogin.php');
include_once('model/modelApp.php');

//DATOS
include_once('data/paciente.php');
include_once('data/usuario.php');



class ControlApp
{

    public $MODELOLOGIN;
    public $MODELOAPP;
    public function __construct()
    {
        $this->MODELOLOGIN = new ModeloLogin();
        $this->MODELOAPP = new ModeloApp();
    }


    /*********************************************************************LOGEO DEL ADMIN********************************************************/
    public function verEstadoPaciente()
    {
        try {
            $paciente = new Paciente();
            $paciente->setDOCUMENTO($_GET['txt_documento_paciente_android']);

            $data = $this->MODELOAPP->verPacienteEstadoActual($paciente);

            if ($data) {
                echo json_encode($data);
            } else {
                echo 0;
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
}
