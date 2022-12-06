<?php

//MODEL
include_once('model/modelLogin.php');

//DATOS
include_once('data/usuario.php');



class ControlLogin
{

    public $MODELOLOGIN;

    public function __construct()
    {
        $this->MODELOLOGIN = new ModeloLogin();
    }


    /*********************************************************************LOGEO DEL ADMIN********************************************************/
    public function Login()
    {
        try {
            /* if (isset($_REQUEST['btn-login'])) { */
            $login = new Usuario();
            $login->setnombreUser($_POST['txt_usuario']);
            $login->setcontraUser($_POST['txt_contra']);

            $acceso = $this->MODELOLOGIN->logeo($login);

            if ($acceso) {
                session_start();
                $_SESSION["id_usuario"] = $acceso->id_usuario;
                $_SESSION["nombre_usuario"] = $acceso->nombre_usuario;
                $_SESSION["contra_usuario"] = $acceso->contra_usuario;
                $_SESSION["foto"] = $acceso->foto;
                echo 1;
            } else {
                echo 0;
            }
            /*   } */
        } catch (Exception $th) {
            throw $th;
        }
    }
}
