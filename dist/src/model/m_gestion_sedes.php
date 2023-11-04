<?php

setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/Bogota');

// $dbm = conectar_mysql();
// $error_personal = null;
// $fecha_hoy = date("Y-m-d");
// $fecha_hora_hoy = date("Y-m-d H:i:s"); //fecha_creacion
// $formulario = variable_exterior("formulario");

$dbm = conectar_mysql();
$formulario = $_POST['formulario'];


if ($formulario == "crear_sede") {

    $nombre_sede = $_POST['nombre_sede'];
    $direccion_sede = $_POST['direccion_sede'];

    $sql = "INSERT INTO sedes (nombre, estado, direccion) VALUES ('$nombre_sede', '1', '$direccion_sede')";
    $query = $dbm->prepare($sql);
    if ($query->execute()) {
        // EJECUTÓ BIEN
?>
        <script>
            alert("La sede se insertó correctamente DOS");
        </script>

    <?php
    } else {
        // ERROR
    ?>
        <script>
            alert("Error! La sede no se insertó correctamente");
        </script>

<?php
    }
}




$consulta = "";




?>