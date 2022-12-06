<?php

include_once('controller/controlSop.php');
include_once('controller/controlLogin.php');
include_once('controller/controlApp.php');


//PHP EXCEL
//require_once 'lib/PHPExcel/Classes/PHPExcel.php';

//EXCEL SPREADSHEET
require 'lib/Excelspreadsheet/vendor/autoload.php';

//ZONA DE HORARIO
date_default_timezone_set("America/Lima");

ini_set("default_charset", "UTF-8");

$controlSop = new ControlSop();
$controlLogin = new ControlLogin();
$controlApp = new ControlApp();

if (!isset($_REQUEST['ruta'])) {
    $controlSop->dashboard();
} else {
    $peticion = $_REQUEST['ruta'];
    if (method_exists($controlSop, $peticion)) {
        call_user_func(array($controlSop, $peticion));
    } else if (method_exists($controlLogin, $peticion)) {
        call_user_func(array($controlLogin, $peticion));
    } else if (method_exists($controlApp, $peticion)) {
        call_user_func(array($controlApp, $peticion));
    } else {
        $controlSop->NoEncontrado();
    }
}
