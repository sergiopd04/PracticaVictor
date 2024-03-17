<?php

require 'Pacientes.php';

$data = json_decode(file_get_contents('php://input'), true);

$action = isset($data["action"]) ? $data["action"] : "";
$id = isset($data["id"]) ? $data["id"] : "";
$sip = isset($data["sip"]) ? $data["sip"] : "";
$dni = isset($data["dni"]) ? $data["dni"] : "";
$nombre = isset($data["nombre"]) ? $data["nombre"] : "";
$apellido1 = isset($data["apellido1"]) ? $data["apellido1"] : "";

$paciente = new Paciente($id,$sip,$dni,$nombre,$apellido1);

$success = true;
$data = [];
$msg = "";

try {

    switch ($action) {
        case "get":
            $data = Paciente::find($filters);
            $msg = "Listado de pacientes";
            break;
        default:
            $success = false;
            $data = [];
            $msg = "No se identifica la acción";
    }
} catch (Exception $e) {
    $success = false;
    $msg = $e->getMessage();
}

$salida = array(
    "data" => $data,
    "msg" => $msg,
    "success" => $success
);

echo json_encode($salida);

