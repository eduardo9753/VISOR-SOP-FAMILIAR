# VISOR WEB SALA DE OPERACIONES
Aplicativo Web para el seguimientos de los estados de cada paciente en Sala de Operaciones 
------------

HERRAMIENTAS :
- Base de Datos: Oracle - MySQL.
- Estilos: CSS3 y Bootstrap 4.
- Lenguaje : Lenguaje PHP.

## Arquitectura MVC
1. MODELO: representación de los datos que maneja el sistema, su lógica de negocio, y sus mecanismos de persistencia.
2. VISTA: Información que se envía al cliente y los mecanismos interacción con éste.
3. CONTROLADOR: intermediario entre el Modelo y la Vista, gestionando el flujo de información entre ellos y las transformaciones para adaptar los datos a las necesidades de cada uno.

## Imagenes
Vista Familiar:
- 1
![SOP01_FAMILIAR](https://user-images.githubusercontent.com/68178186/169623191-21b8074f-3c33-4baf-9823-60aeb7cd6f3b.PNG)




### SCRIPT DE LA BASE DE DATOS
````sql
CREATE DATABASE visor_SOP DEFAULT CHARACTER SET UTF8MB4;
SET default_storage_engine = INNODB;



USE visor_SOP;



#-------------------------------------------------------------------------------------------------
#TABLA USUARIO
#-------------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuario(
  id_usuario            int PRIMARY KEY AUTO_INCREMENT,
  nombre_usuario        VARCHAR(100) NOT NULL,
  contra_usuario        VARCHAR(100) NOT NULL,
  perfil                VARCHAR(100) NULL,
  area_usuario          VARCHAR(100) NULL,
  foto                  VARCHAR(100) NULL default 'foto.jpg'
)ENGINE=InnoDB default charset=UTF8MB4;
#-------------------------------------------------------------------------------------------------





#-------------------------------------------------------------------------------------------------
#TABLA VIDEOS
#-------------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS VIDEO(
  id_video             INT PRIMARY KEY AUTO_INCREMENT,
  nombre_video         VARCHAR(100) NOT NULL,
  descripcion_video    TEXT NULL,
  id_usuario           INT  NULL,
  fecha_registro_sys   TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
  fecha_update_sys     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB default charset=UTF8MB4;
#-------------------------------------------------------------------------------------------------








#-------------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS TIEMPO_SOP(
  ID_NHC               VARCHAR(15) PRIMARY KEY NULL,
  NOMBRE_PAC           VARCHAR(100) NULL,
  DOCUMENTO            VARCHAR(15) NULL,
  PATERNO              VARCHAR(40) NULL,
  MATERNO              VARCHAR(40) NULL,
  SEXO_PAC             VARCHAR(2) NULL,
  NOMBRE_PROFESIONAL   VARCHAR(100) NULL,
  NOMBRE_ESPECIALIDAD  VARCHAR(100) NULL,
  PRIMER_NOMBRE        VARCHAR(40) NULL,
  SEGUNDO_NOMBRE       VARCHAR(40) NULL,
  FECHA_CHEKLIST       VARCHAR(40) NULL,
  FECHA_RECUPERACION   VARCHAR(40) NULL,
  FECHA_SALIDA         VARCHAR(40) NULL,
  FECHA_REAL           DATE NULL,
  ESTADO               INT  NULL,
  ESTADO_BAJA          INT  NULL,
  id_usuario           INT  NULL,
  fecha_registro_sys   TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
  fecha_update_sys     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB default charset=UTF8MB4;
#TABLA TIEMPO SOP
#---> 1 : ES SALA
#---> 2 : EN RECUPERACION
#---> 3 : DE ALTA
#---> 4 : DESAPARECE DEL VISOR
#---> 5 : FALLECIDO
#ESTADO_BAJA: CAUNDO PASA AL ESTADO = 3 , ACTUALIZAMOS EL DATO DESPUES DE 1 HORA 
#-------------------------------------------------------------------------------------------------







#-------------------------------------------------------------------------------------------------
#FORANEAS DATA
#-------------------------------------------------------------------------------------------------
ALTER TABLE TIEMPO_SOP ADD FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario);
ALTER TABLE VIDEO ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);
#-------------------------------------------------------------------------------------------------








#-------------------------------------------------------------------------------------------------
#UPDATE DATA -  JALAR POR FECHA ACTUAL Y EN EL ULTIMO PASO ACTUALIZAR LA FECHA A "0000-00-00"
#-------------------------------------------------------------------------------------------------
SELECT * FROM tiempo_sop TSOP WHERE TSOP.ESTADO IN ('1','2','3')
              AND DATE_FORMAT(TSOP.FECHA_REAL,'%d') = '15'
              ORDER BY TSOP.FECHA_CHEKLIST ASC

````

