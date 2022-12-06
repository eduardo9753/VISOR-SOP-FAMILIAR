<?php

include_once('config/conexionOracle.php');
include_once('config/conexionMysql.php');




class ModeloUtils
{

    public $PDO;
    public $MYSQL;

    public function __construct()
    {
        try {
            $this->PDO = new ConexionOracle(); //INICIANDO LA CONEXION A LA BD
            $this->MYSQL = new ClassConexion();
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //REEMPLAZAR CARACTER EXTRAÑOS/SIGNOS/TILDES
    public function DELETE_ACENTO($cadena)
    {
        //Reemplazamos la A y a
        $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $cadena
        );

        //Reemplazamos la E y e
        $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena
        );

        //Reemplazamos la I y i
        $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena
        );

        //Reemplazamos la O y o
        $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena
        );

        //Reemplazamos la U y u
        $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena
        );

        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç', '?'),
            array('N', 'n', 'C', 'c', 'Ñ'),
            $cadena
        );
        return $cadena;
    }

    /*******************************************************************MUNUTOS TRANSCURRIDOS**************************************************************************/
    public function minutosSalida($FECHA_SALIDA, $fecha_actual)
    {
        try {
            $dateTimeObject1 = date_create($FECHA_SALIDA);
            $dateTimeObject2 = date_create($fecha_actual);

            $difference = date_diff($dateTimeObject1, $dateTimeObject2);
            //echo ("The difference in hours is:");
            //echo $difference->h;
            //echo "\n";
            $minutes = $difference->days * 24 * 60;
            $minutes += $difference->h * 60;
            $minutes += $difference->i;
            //echo ("The difference in minutes is:");
            return $minutes;
            //return $difference->h;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
    /*******************************************************************************************************************************************************************/

    //FUNCION QUE ME RETORNA LA PRIMERA LETRA DE UNA PALABRA
    public function primeraLetra($cadena)
    {
        try {
            $letra = substr($cadena, 0, 2);
            return $letra;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //PINTA NOMBRE DEL MES ACTUAL
    public function mesActualCadena()
    {
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mesActual = $meses[date('n') - 1];
        return $mesActual;
    }

    public function diaActualCadena()
    {
        setlocale(LC_ALL, "es_ES");
        $date = DateTime::createFromFormat("d/m/Y", Date("d/m/Y"));
        return strftime("%A", $date->getTimestamp());
    }
}
