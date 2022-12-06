<?php

//MODEL

include_once('model/modelLogin.php');
include_once('model/modelSop.php');

//DATOS
include_once('data/usuario.php');
include_once('data/paciente.php');

//UTILS
include_once('utils/utils.php');

class ControlSop
{

    public $MODEL;
    public $MODELSOP;
    public $UTILS;

    public function __construct()
    {
        $this->MODELSOP = new ModeloSop();
        $this->MODEL = new ModeloLogin();
        $this->UTILS = new ModeloUtils();
    }

    public  function index() //VISTA INDEX
    {
        include_once('view/admin/login.php');
    }

    public function dashboard()
    {
        try {
            $dataSop = $this->MODELSOP->checkListPaciente();
            $dataRecuperacion = $this->MODELSOP->recuperacionPaciente();
            $dataSalida = $this->MODELSOP->salidaPaciente();
            $dataSopEstadoSalidaMySql = $this->MODELSOP->allPacienteEstadoSalida();

            $date = Date('Y-m-d');
            /*INSERTAMOS DATOS CHEKLIST  COLOR VERDE*/
            foreach ($dataSop as $data) :
                if ($data->FECHA_REAL === $date && !is_null($data->FECHA_CHECKLIST)) {
                    $paciente = new Paciente();
                    $paciente->setID_NHC($data->NHC);
                    $paciente->setNOMBRE_PAC($this->UTILS->DELETE_ACENTO($data->NOMBRE_PAC));
                    $paciente->setDOCUMENTO($data->DOCUMENTO);
                    $paciente->setSEXO_PAC($data->SEXO_PAC);
                    $paciente->setNOMBRE_ESPECIALIDAD($data->NOMBRE_ESPECIALIDAD);
                    $paciente->setNOMBRE_PROFESIONAL($data->NOMBRE_PROFESIONAL);
                    $paciente->setPATERNO($data->PATERNO);
                    $paciente->setMATERNO($data->MATERNO);
                    $paciente->setPRIMER_NOMBRE($data->PRIMER_NOMBRE);
                    $paciente->setSEGUNDO_NOMBRE($data->SEGUNDO_NOMBRE);
                    $paciente->setFECHA_CHEKLIST($data->FECHA_CHECKLIST);
                    $paciente->setFECHA_REAL($data->FECHA_REAL);
                    $paciente->setESTADO('1');
                    $this->MODELSOP->insertPacienteSop($paciente);
                }
            endforeach;

            

            /*ACTUALIZAMOS DATOS FECHA DE RECUPERACION COLOR AMARILLO*/
            foreach ($dataRecuperacion as $data) :
                if ($data->FECHA_REAL === $date && !is_null($data->FECHA_RECUPERACION)) {  //&& $DATAMYSQL->ESTADO == 1
                    $paciente = new Paciente();
                    $paciente->setFECHA_RECUPERACION($data->FECHA_RECUPERACION);
                    $paciente->setESTADO('2');
                    $paciente->setID_NHC($data->NHC);
                    $this->MODELSOP->updatePacienteSopFechaRecuperacion($paciente);
                }
            endforeach;



            /*ACTUALIZAMOS DATOS FECHA DE SALIDA COLOR AZUL*/
            foreach ($dataSalida as $data) :
                if ($data->FECHA_REAL === $date && !is_null($data->FECHA_SALIDA)) { //&& $DATAMYSQL->ESTADO == 2
                    $paciente = new Paciente();
                    $paciente->setFECHA_SALIDA($data->FECHA_SALIDA);
                    $paciente->setESTADO('3');
                    $paciente->setESTADO_BAJA('0');
                    $paciente->setID_NHC($data->NHC);
                    $this->MODELSOP->updatePacienteSopFechaSalida($paciente);
                }
            endforeach;



            /*ACTUALIZAMOS DATOS FECHA DE PARA DESAPARECER*/
            foreach ($dataSopEstadoSalidaMySql as $data) :
                $fecha_actual = date('d-m-Y H:i:s');
                $resul = $this->UTILS->minutosSalida($data->FECHA_SALIDA, $fecha_actual);

                if ($data->ESTADO_BAJA == 0 && $data->FECHA_REAL === $date) {
                    if ($resul >= 60) { //minutos totales para que desaparezca
                        $paciente = new Paciente();
                        $paciente->setESTADO('4');
                        $paciente->setID_NHC($data->ID_NHC);
                        $this->MODELSOP->borrarPacienteSopFechaSalida($paciente);
                    }
                } 
            endforeach;

            $dataSopMySql = $this->MODELSOP->allPaciente();
            $i = 0;

            include_once('view/visor/virsorPaciente.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function verHora()
    {
        try {
            $FECHA_SALIDA = '12-02-2022 08:53:05';
            $fecha_actual = '12-02-2022 10:49:05';
            $resul = $this->UTILS->minutosSalida($FECHA_SALIDA, $fecha_actual);
            echo "<br>";
            echo "minutos: " . $resul;
            echo "<br>";
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function Temperatura()
    {
        try {
            //$descripcion = $weather_date['weather'][0]['description'];
            $city_name = "Lima";
            $lang = "es";
            $temp = $this->MODELSOP->temperaturaActualCiudad($city_name);
            $temp['T_Celcius'];
            $temp['T_Fahrenheit'];
            $API_KEY = "b45ee9e53ac46cac0c24a3d0c3461f0c";
            $ciudad = "Lima";
            $URI_API = "https://api.openweathermap.org/data/2.5/weather?q=$ciudad&appid=$API_KEY&lang=$lang";
            $weather_date = json_decode(file_get_contents($URI_API), true);
            $img =  $weather_date['weather'][0]['icon'];
            $IMG_API = "http://openweathermap.org/img/wn/$img@2x.png";
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function NoEncontrado()
    {
        include_once('view/404/noEncontrado.php');
    }
}
