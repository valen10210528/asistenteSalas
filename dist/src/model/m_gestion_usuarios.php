<?php

setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/Bogota');

// $dbm = conectar_mysql();
// $error_personal = null;
// $fecha_hoy = date("Y-m-d");
// $fecha_hora_hoy = date("Y-m-d H:i:s"); //fecha_creacion
// $formulario = variable_exterior("formulario");

// $resultados = array();
// $resultados_final = array();

// $consulta = "";

$dbm = conectar_mysql();
if (isset($_POST['formulario'])) {
    $formulario = $_POST['formulario'];
    # code...
} else {
    $formulario = "";
}



if ($formulario == "crear_usuario" && $formulario != "") {
    // Importación de valores para insert
    $numero_identificacion = $_POST['numero_identificacion'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    // Crear usuario
    $sql = "INSERT INTO usuarios (usuario, nombres, apellidos, celular, email, rol, estado, fecha) VALUES ('$usuario', '$nombres', '$apellidos', '$celular', '$email', '1', '1', NOW())";
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

// Actualizar usuario
if ($formulario == "actualizar_usuario" && $formulario != "") {
    $nombre_sede = $_POST['nombre_sede'];
    $direccion_sede = $_POST['direccion_sede'];
    $estado = $_POST['estado'];
    $id = $_POST['id'];

    $sql = "UPDATE usuarios SET nombre = '$nombre_sede', direccion = '$direccion_sede', estado = '$estado' WHERE id ='$id' ";
    $query = $dbm->prepare($sql);
    if ($query->execute()) {
    ?>
        <script>
            alert("Sede actualizada correctamente");
        </script>
    <?php
    } else {
    ?>
        <script>
            alert("Error! La sede no fue actualizada correctamente");
        </script>

<?php
    }
}
$sql = "SELECT * FROM usuarios";
$query = $dbm->prepare($sql);
$query->execute();
$sedes = array_asociativo($query);

?>