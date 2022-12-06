<?php

include_once('config/conexionOracle.php');
include_once('config/conexionMysql.php');




class ModeloSop
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



    /*******************************************LOGEO DEL USUARIO********************************************/
    public function checkListPaciente()
    {
        try {
            $sql = "SELECT distinct
            CHE.NUMORDEN NHC,
            --CHE.OBSERVACIONES,
            CHE.USUARIOMOD U_CRE,
            TO_CHAR(CHE.FECHAMOD,'DD-MM-YYYY HH24:MI:SS') FECHA_CHECKLIST,
            TO_CHAR(CHE.FECHAMOD, 'YYYY-MM-DD') FECHA_REAL,
            HIS.NOMBRE NOMBRE_PAC,
            substr(HIS.NOMBRE,0,instr(HIS.NOMBRE,' ',1,1)) PATERNO,
            substr(HIS.NOMBRE,instr(HIS.NOMBRE,' ',1,1) +1 ,instr(HIS.NOMBRE,' ',1,2) - instr(HIS.NOMBRE,' ',1,1)) MATERNO,
            substr(HIS.NOMBRE,instr(HIS.NOMBRE,' ',1,2) +1 ,instr(HIS.NOMBRE,' ',1,3) - instr(HIS.NOMBRE,' ',1,2)) PRIMER_NOMBRE, 
            substr(HIS.NOMBRE,instr(HIS.NOMBRE,' ',1,3) +1,length(HIS.NOMBRE) - instr(HIS.NOMBRE,' ',1,3)) SEGUNDO_NOMBRE,
            HIS.SEXO SEXO_PAC,
            HIS.NUMDOC DOCUMENTO,
            MED.NOMBRE  AS NOMBRE_PROFESIONAL, 
            SERV.DESCRIPCION  AS NOMBRE_ESPECIALIDAD
            --CAB.DESCRIPCION D_CHECK,
            --ITE.DESCRIPCION,
            --DECODE(CHED.IDCHKLISTITEMS,'499','1. Cabecera de la cama > 30 grados, Si hay criterio documentar','500','2. Indicación de profilaxis para tromboembolia venosa, para el paciente. Si hay criterio: Compresor o medias TEP o anticoagulado','501','3. Profilaxis de úlcera péptica indicada para el paciente','502','4. Suspensión de sedación cada mañana','503','5. Uso de clorhexidina para higiene oral','504','6. Uso de sondas de succión por cada vez','505','7. Sujeción de TET con cinta','506','8. Medida de cuff cada 12 horas') XD,
            --CHE.OBSERVACIONES
            --CHE.LINEA,
            --CHED.IDCHKLISTITEMS,
            --CHED.VALOR
            --CHED.IDCHKLISTRES
            FROM  HOSIXJDN.D_CHKLISTRES CHE
            INNER JOIN HOSIXJDN.A_HISTORIAS HIS ON HIS.NUMORDEN = CHE.NUMORDEN
            --INNER JOIN HOSIXJDN.D_IDININF INFCAB ON INFCAB.NUMEPISODIO = CHE.NUMEPIS
            INNER JOIN HOSIXJDN.D_IDININF INFCAB ON INFCAB.NUMORDEN = CHE.NUMORDEN
            left JOIN HOSIXJDN.D_IDININFDET INFDET ON INFCAB.IDIDININF = INFDET.IDIDININF
            INNER JOIN HOSIXJDN.A_MEDICOS MED ON MED.CODIGO = INFCAB.MEDICO
            LEFT JOIN HOSIXJDN.D_IDINOPCION OPCRES ON OPCRES.IDIDINOPCION = INFDET.IDIDINOPCION
            INNER JOIN HOSIXJDN.A_SERVICIOS SERV ON SERV.CODIGO = MED.SERVICIO
            --INNER JOIN HOSIXJDN.D_CHKLIST CAB ON  CAB.ID = CHE.IDCHKLIST
            --INNER JOIN HOSIXJDN.D_CHKLISTITEMS ITE ON ITE.CHKLIST = CHE.IDCHKLIST
            --INNER JOIN  HOSIXJDN.D_CHKLISTRESDET CHED ON CHED.IDCHKLISTRES =  CHE.ID
             WHERE CHE.IDCHKLIST IN ('18')
             --AND CHE.NUMORDEN ='5141730'
             AND CHE.FECHA >= SYSDATE -1
             --AND to_date(CHE.FECHA) >= SYSDATE -1
             AND DECODE (OPCRES.NOMBRE, NULL, TO_CHAR(INFDET.VALOR), TO_CHAR(OPCRES.NOMBRE))  = '1'
             and SERV.DESCRIPCION   NOT LIKE '%EMER%' 
             and CHE.OBSERVACIONES LIKE '%SOP%'
             AND INFCAB.IDIDINPLAN = 102 
             ORDER BY HIS.NOMBRE";
            $stm = $this->PDO->ConectarOracle()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function recuperacionPaciente()
    {
        try {
            $sql = "SELECT 
            --distinct HIS.NUMDOC DNI_PAC,
            HIS.NOMBRE NOMBRE_PAC,
            --SUBSTR(HP.VALOR,6,6)  REGISTRO,
            --SUBSTR(HP.VALOR,1,4)  ANIO_REG,         
            HIS.NUMORDEN NHC,
            --CHE.FECHA CHEKLIST,
            TO_CHAR(INFCAB.FECHA, 'DD-MM-YYYY HH24:MI:SS')  FECHA_RECUPERACION,
            TO_CHAR(INFCAB.FECHA,  'YYYY-MM-DD') FECHA_REAL
            --TIPOPLAN.NOMBRE NOMBRE_PLANTILLA,
            --MED.CODIGO COD_PROFESIONAL,
            --SUBSTR (HIS.NOMBRE,1,7),
            --MED.NOMBRE NOMBRE_PROFESIONAL
            --MED.NUMMATRICULA CMP_PROFESIONAL,
            --SERV.CODIGO COD_ESPECIALIDAD,
            --SERV.DESCRIPCION NOMBRE_ESPECIALIDAD,
            --CAMPLA.TEXTO,
            --DECODE (OPCRES.NOMBRE, NULL, TO_CHAR(INFDET.VALOR), TO_CHAR(OPCRES.NOMBRE)) RESPUESTA, TO_CHAR(INFDET.DESCRIPCION) DESC_RESPUESTA,
            --CIA.NOMBRE1 AS NOM_CIA,
            --TIPODI.DESCRIPCION AS TIP_PACIENTE    
            --CHE.FECHA CHEKLIST
               
            FROM HOSIXJDN.D_IDININF INFCAB
            
            INNER JOIN HOSIXJDN.D_IDININFDET INFDET ON INFCAB.IDIDININF = INFDET.IDIDININF
            INNER JOIN HOSIXJDN.A_HISTORIAS HIS ON HIS.NUMORDEN = INFCAB.NUMORDEN
            INNER JOIN HOSIXJDN.D_IDINPLAN TIPOPLAN ON TIPOPLAN.IDIDINPLAN = INFCAB.IDIDINPLAN
            INNER JOIN HOSIXJDN.D_IDINCAMPLAN CAMPLA ON CAMPLA.IDIDINCAMPLAN = INFDET.IDIDINCAMPLAN
            INNER JOIN HOSIXJDN.A_MEDICOS MED ON MED.CODIGO = INFCAB.MEDICO
            INNER JOIN HOSIXJDN.A_SERVICIOS SERV ON SERV.CODIGO = MED.SERVICIO
            LEFT JOIN HOSIXJDN.D_IDINOPCION OPCRES ON OPCRES.IDIDINOPCION = INFDET.IDIDINOPCION
            LEFT JOIN HOSIXJDN.F_IDATIDENTIFIC DI ON ( DI.NUMORDEN = INFCAB.NUMORDEN AND DI.TIPOMOVTO = INFCAB.TIPOEPISODIO AND DI.ANOEPISODIO = 0 AND DI.NUMEPISODIO = INFCAB.NUMEPISODIO)      
            LEFT JOIN HOSIXJDN.F_TIPODI TIPODI ON TIPODI.IDTIPODI = DI.IDTIPODI
            LEFT JOIN HOSIXJDN.F_CIAS CIA ON CIA.CODIGO = DI.IDCIA
            --left join HOSIXJDN.A_INGRESOSCARACTER HP on HP. IDTIPOSINGCARACTER = '10001' and   INFCAB.NUMEPISODIO=hp.NINGRESO  AND hp.VALOR IS NOT NULL
            --LEFT JOIN HOSIXJDN.D_CHKLISTRES CHE ON INFCAB.NUMEPISODIO = CHE.NUMEPIS
            
            WHERE INFCAB.IDIDINPLAN = 2032
            AND INFDET.IDIDINCAMPLAN IN (16906)
            --AND INFCAB.TIPOEPISODIO = 'I'
            --and HIS.NUMORDEN='5039310'
            --AND CHE.FECHA like '%/%'
            AND INFCAB.FECHA >= SYSDATE -1
            ORDER BY HIS.NUMORDEN ASC";
            $stm = $this->PDO->ConectarOracle()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function salidaPaciente()
    {
        try {
            $sql = "SELECT 
            --distinct HIS.NUMDOC DNI_PAC,
            HIS.NOMBRE NOMBRE_PAC,
            --SUBSTR(HP.VALOR,6,6)  REGISTRO,
            --SUBSTR(HP.VALOR,1,4)  ANIO_REG,         
            HIS.NUMORDEN NHC,
            --CHE.FECHA CHEKLIST,
            TO_CHAR(INFCAB.FECHA, 'DD-MM-YYYY HH24:MI:SS') FECHA_SALIDA,
            TO_CHAR(INFCAB.FECHA, 'YYYY-MM-DD') FECHA_REAL
            --TIPOPLAN.NOMBRE NOMBRE_PLANTILLA,
            --MED.CODIGO COD_PROFESIONAL,
            --SUBSTR (HIS.NOMBRE,1,7),
            --MED.NOMBRE NOMBRE_PROFESIONAL
            --MED.NUMMATRICULA CMP_PROFESIONAL,
            --SERV.CODIGO COD_ESPECIALIDAD,
            --SERV.DESCRIPCION NOMBRE_ESPECIALIDAD,
            --CAMPLA.TEXTO,
            --DECODE (OPCRES.NOMBRE, NULL, TO_CHAR(INFDET.VALOR), TO_CHAR(OPCRES.NOMBRE)) RESPUESTA, TO_CHAR(INFDET.DESCRIPCION) DESC_RESPUESTA,
            --CIA.NOMBRE1 AS NOM_CIA,
            --TIPODI.DESCRIPCION AS TIP_PACIENTE    
            --CHE.FECHA CHEKLIST
               
            FROM HOSIXJDN.D_IDININF INFCAB
            
            INNER JOIN HOSIXJDN.D_IDININFDET INFDET ON INFCAB.IDIDININF = INFDET.IDIDININF
            INNER JOIN HOSIXJDN.A_HISTORIAS HIS ON HIS.NUMORDEN = INFCAB.NUMORDEN
            INNER JOIN HOSIXJDN.D_IDINPLAN TIPOPLAN ON TIPOPLAN.IDIDINPLAN = INFCAB.IDIDINPLAN
            INNER JOIN HOSIXJDN.D_IDINCAMPLAN CAMPLA ON CAMPLA.IDIDINCAMPLAN = INFDET.IDIDINCAMPLAN
            INNER JOIN HOSIXJDN.A_MEDICOS MED ON MED.CODIGO = INFCAB.MEDICO
            INNER JOIN HOSIXJDN.A_SERVICIOS SERV ON SERV.CODIGO = MED.SERVICIO
            LEFT JOIN HOSIXJDN.D_IDINOPCION OPCRES ON OPCRES.IDIDINOPCION = INFDET.IDIDINOPCION
            LEFT JOIN HOSIXJDN.F_IDATIDENTIFIC DI ON ( DI.NUMORDEN = INFCAB.NUMORDEN AND DI.TIPOMOVTO = INFCAB.TIPOEPISODIO AND DI.ANOEPISODIO = 0 AND DI.NUMEPISODIO = INFCAB.NUMEPISODIO)      
            LEFT JOIN HOSIXJDN.F_TIPODI TIPODI ON TIPODI.IDTIPODI = DI.IDTIPODI
            LEFT JOIN HOSIXJDN.F_CIAS CIA ON CIA.CODIGO = DI.IDCIA
            --left join HOSIXJDN.A_INGRESOSCARACTER HP on HP. IDTIPOSINGCARACTER = '10001' and   INFCAB.NUMEPISODIO=hp.NINGRESO  AND hp.VALOR IS NOT NULL
            --LEFT JOIN HOSIXJDN.D_CHKLISTRES CHE ON INFCAB.NUMEPISODIO = CHE.NUMEPIS
            
            WHERE INFCAB.IDIDINPLAN = 2132
            AND INFDET.IDIDINCAMPLAN IN (10414)
            --AND INFCAB.TIPOEPISODIO = 'I'
            --and HIS.NUMORDEN='5039310'
            --AND CHE.FECHA like '%/%'
            AND INFCAB.FECHA >= SYSDATE -1
            ORDER BY HIS.NUMORDEN ASC";
            $stm = $this->PDO->ConectarOracle()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //INSERTA DATA SOP
    public function insertPacienteSop(Paciente $paciente)
    {
        try {
            $sql = "INSERT INTO TIEMPO_SOP(ID_NHC,
            NOMBRE_PAC,
            DOCUMENTO,
            SEXO_PAC,
            NOMBRE_PROFESIONAL,
            NOMBRE_ESPECIALIDAD,
            PATERNO,
            MATERNO,
            PRIMER_NOMBRE,
            SEGUNDO_NOMBRE,
            FECHA_CHEKLIST,
            FECHA_REAL,
            ESTADO) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stm = $this->MYSQL->ConectarBD()->prepare($sql);
            $stm->execute(array(
                $paciente->getID_NHC(),
                $paciente->getNOMBRE_PAC(),
                $paciente->getDOCUMENTO(),
                $paciente->getSEXO_PAC(),
                $paciente->getNOMBRE_PROFESIONAL(),
                $paciente->getNOMBRE_ESPECIALIDAD(),
                $paciente->getPATERNO(),
                $paciente->getMATERNO(),
                $paciente->getPRIMER_NOMBRE(),
                $paciente->getSEGUNDO_NOMBRE(),
                $paciente->getFECHA_CHEKLIST(),
                $paciente->getFECHA_REAL(),
                $paciente->getESTADO()
            ));
            return  $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function updatePacienteSopFechaRecuperacion(Paciente $paciente)
    {
        try {
            $diaActual = date("Y-m-d");
            $sql = "UPDATE TIEMPO_SOP SET FECHA_RECUPERACION =?, ESTADO=? WHERE ID_NHC=? AND FECHA_REAL = '$diaActual' ";
            $stm = $this->MYSQL->ConectarBD()->prepare($sql);
            $stm->execute(array(
                $paciente->getFECHA_RECUPERACION(),
                $paciente->getESTADO(),
                $paciente->getID_NHC()
            ));
            return  $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function updatePacienteSopFechaSalida(Paciente $paciente)
    {
        try {
            $diaActual = date("Y-m-d");
            $sql = "UPDATE TIEMPO_SOP SET FECHA_SALIDA =?, ESTADO=? ,ESTADO_BAJA=? WHERE ID_NHC=? AND FECHA_REAL = '$diaActual' ";
            $stm = $this->MYSQL->ConectarBD()->prepare($sql);
            $stm->execute(array(
                $paciente->getFECHA_SALIDA(),
                $paciente->getESTADO(),
                $paciente->getESTADO_BAJA(),
                $paciente->getID_NHC()
            ));
            return  $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function borrarPacienteSopFechaSalida(Paciente $paciente)
    {
        try {
            $diaActual = date("Y-m-d");
            $sql = "UPDATE TIEMPO_SOP SET ESTADO=? WHERE ID_NHC=? AND FECHA_REAL = '$diaActual'";
            $stm = $this->MYSQL->ConectarBD()->prepare($sql);
            $stm->execute(array(
                $paciente->getESTADO(),
                $paciente->getID_NHC()
            ));
            return  $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    
    //DATA PACIENTE ESTADOS
    public function allPaciente()
    {
        try {
            $diaActual = date("Y-m-d");
            $sql = "SELECT * FROM tiempo_sop TSOP WHERE TSOP.ESTADO IN ('1','2','3')
            AND DATE_FORMAT(TSOP.FECHA_REAL,'%Y-%m-%d') = '$diaActual' 
            ORDER BY TSOP.FECHA_CHEKLIST ASC";
            $stm = $this->MYSQL->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function allPacienteEstadoSalida()
    {
        try {
            $sql = "SELECT * FROM tiempo_sop TSOP WHERE TSOP.ESTADO_BAJA IN ('0')";
            $stm = $this->MYSQL->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function temperaturaActualCiudad($ciudad)
    {
        try {
            $API_KEY = "b45ee9e53ac46cac0c24a3d0c3461f0c";
            $ciudad = "Lima";
            $lang = "es";
            $URI_API = "https://api.openweathermap.org/data/2.5/weather?q=$ciudad&appid=$API_KEY&lang=$lang";

            $weather_date = json_decode(file_get_contents($URI_API), true);
            $temperatura_in_celcius = $weather_date['main']['temp'] - 273.15;
            $temperatura_in_fahrenheit = ($temperatura_in_celcius * (9 / 5)) + 32;
            $descripcion = $weather_date['weather'][0]['description'];
            $celcius =  round($temperatura_in_celcius);
            $fahrenheit = round($temperatura_in_fahrenheit);
            $img =  $weather_date['weather'][0]['icon'];
            $IMG_API = "http://openweathermap.org/img/wn/$img@2x.png";
            $datos = array();

            $datos = [
                "T_Celcius"     => $celcius,
                "T_Fahrenheit"  => $fahrenheit,
                "Descripcion"   => $descripcion,
                "Imagen"        => $IMG_API
            ];
            return $datos;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
}
