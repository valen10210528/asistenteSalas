<?php

setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/Bogota');
// $tags_page = strftime("%A, %d de %B de %Y %H:%M ") . '<br/>';

$error_personal = "";
$fecha_hoy = date("Y-m-d");
$fecha_hora_hoy = date("Y-m-d H:i:s");
// $dbm_sicuso = conectar_sicuso();
$dbm = conectar_mysql();

$formulario = variable_exterior("formulario");

$sql = "SELECT * FROM sedes WHERE estado = 1";
$query = $dbm->prepare($sql);
$query->execute();
$sedes = array_asociativo($query);
$disponibilidad_profesional = '{}';

$sql = "SELECT * FROM asignaturas WHERE estado = 1";
$query = $dbm->prepare($sql);
$query->execute();
$asignaturas  = array_asociativo($query);


//FILTRO
if ($formulario == "filtrar" || $formulario == "") {
	$comodin = '';
	//llenar CALENDARIO
	// $id_personal_buscar = $_SESSION['id_usuario'];
	if (!empty($conexiones_sedes_filtro)) {
		$agendas_totales = array(); // Arreglo para almacenar las agendas de todas las sedes

		foreach ($conexiones_sedes_filtro as $key => $conexion_filtro) {
			/* DESC SE AGREGA LA OBSERVACION CONCATENADA CON EL NOMBRE DE LA SEDE SOLO SI NO ES NULO ESE VALOR*/
			/* SERVICIO SE PUEDEN CAMBIAR LOS SIGNOS POR LOS QUE SE SEPARA EL SERVICIO*/
			$sql = "SQL";

			$disponibilidad_prof = $conexion_filtro->prepare($sql);
			$disponibilidad_prof->execute();
			// var_dump($sql);

			$agendas_sede = array(); // Arreglo para almacenar las agendas de una sede específica

			while ($fila = $disponibilidad_prof->fetch(PDO::FETCH_ASSOC)) {
				$agendas_sede[] = $fila; // Agregar cada fila (agenda) al arreglo de la sede
			}

			// Agregar el arreglo de agendas de la sede actual al arreglo de agendas totales
			$agendas_totales = array_merge($agendas_totales, $agendas_sede);
		}

		$array_total = array(); // Arreglo para almacenar las agendas de todas las sedes
		foreach ($agendas_totales as $key => $value) {
			if ($value['start'] || $value['end']) {
				// echo "hpña";
				$value['start'] = validarfecha_hora($value['start'], 'solo_hora');
				$value['end'] = validarfecha_hora($value['end'], 'solo_hora');
				$value['end'] = validarfecha_hora($value['end'], 'solo_hora');
				// var_dump($value);
				$array_total[] = $value;
			}
		}
		$disponibilidad_profesional = json_encode($array_total);
	}
	// var_dump($disponibilidad_profesional);
	// die;
}


function validarfecha_hora($fecha, $horario)
{

	$fecha_inicial = str_replace(' ', 'T', $fecha);

	$fecha_separada =  explode('T', $fecha_inicial);
	if ($horario == 'minimo') {

		$fecha_configurada = $fecha_separada[0] . 'T06:00';
	} else if ($horario == 'solo_hora') {
		$fecha_configurada = $fecha_inicial;
	} else {
		$fecha_configurada = $fecha_separada[0] . 'T18:00';
	}

	return $fecha_configurada;
}
