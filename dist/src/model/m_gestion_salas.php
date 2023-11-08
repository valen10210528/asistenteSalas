<?php

setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/Bogota');

$dbm = conectar_mysql();
$error_personal = null;
$fecha_hoy = date("Y-m-d");
$fecha_hora_hoy = date("Y-m-d H:i:s"); //fecha_creacion
$formulario = variable_exterior("formulario");

$resultados = array();
$resultados_final = array();

$consulta = "";

//Crear sala
if ($formulario == "crear_sala" && $formulario != "") {

    $nombre_sede = $_POST['id_sede'];
    $direccion_sede = $_POST['direccion_sede'];

    $sql = "INSERT INTO sedes (nombre, estado, direccion) VALUES ('$nombre_sede', '1', '$direccion_sede')";
    $query = $dbm->prepare($sql);
    if ($query->execute()) {
        // EJECUTÓ BIEN
?>
        <script>
            alert("La sede se insertó correctamente");
        </script>

    <?php
    } else {
        // ERROR DOS
    ?>
        <script>
            alert("Error! La sede no se insertó correctamente");
        </script>

    <?php
    }
}




$sql = "SELECT * FROM sedes WHERE estado = 1";
$query = $dbm->prepare($sql);
$query->execute();
$sedes = array_asociativo($query);



?>