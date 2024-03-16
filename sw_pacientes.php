
<?php
require __DIR__."/models/Medico.php";

// Recogida de parámetros con POST (AJAX Fetch ECMAScript 6)
$data = json_decode(file_get_contents('php://input'), true);
$action = isset($data["action"])? $data["action"]:"";
$filters = isset($data["filters"])? $data["filters"]:[];
$arrMedico = isset($data["medico"])? $data["medico"]:[];

// Inicialización de variables
$success = true;
$data = [];
$msg = "";

// Selección de la acción elegida
try {
    switch ($action){
        case "get":
            $data = Medico::find($filters);
            $msg = "Listado de médicos";
            break;

        case "insert":
            $medico = new Medico($arrMedico["sip"], $arrMedico["nombre"]);
            if ($medico->insert()) {
                $msg = "Médico insertado correctamente.";
            } else {
                $success = false;
                $msg = "Error al insertar el médico.";
            }
            break;

        default:
            $success = false;
            $data = [];
            $msg = "Opción no soportada.";
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

// Verifica que no falle la codificación en el JSON
if ($salida= json_encode($salida)){
    echo $salida;

} else {
    $salida = array(
        "data" => [],
        "msg" => "Error al parsear el JSON",
        "success" => false
    );

    echo json_encode($salida);
}
