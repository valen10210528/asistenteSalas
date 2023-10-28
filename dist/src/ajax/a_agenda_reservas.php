<?php
include "../../seguridad/conexion.php";

session_start();
$hora_actual = date("H:i:s");
$dbm_mysql = conectar_mysql();
$response = [];
$fecha_hora_hoy = date("Y-m-d H:i:s");
$fecha_hoy = date("Y-m-d");

// Verificar si la solicitud es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recibir los datos enviados por la solicitud POSenviar_emailT
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data['accion'] == "eliminar_cita") {
        $response = array('mensaje' => 'error');
    }

    if ($data['accion'] == "generar_cita") {
        $response = array('resultado' => 'error_no_guardado');
    }
    echo json_encode($response);
} else {
    echo 'Solicitud no válida';
}

function array_($resultado)
{
    $var = array();
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $var[] = $fila;
    }
    return $var;
}
