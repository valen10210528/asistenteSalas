<?php

setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/Bogota');
$tags_page = strftime("%A, %d de %B de %Y %H:%M ") . '<br/>';

$error_personal = "";
$fecha_hoy = date("Y-m-d");
$fecha_hora_hoy = date("Y-m-d H:i:s");
// $dbm_sicuso = conectar_sicuso();
$dbm = conectar_mysql();

$formulario = variable_exterior("formulario");
// $dbm_conexion_sede_montevideo = "";

$conexiones_sedes = conectar_sicuso_sede(1);

if (!empty($conexiones_sedes)) {
	$agendas_totales = array(); // Arreglo para almacenar las agendas de todas las sedes

	foreach ($conexiones_sedes as $key => $sicuso) {
		$sql = "SELECT empresa FROM empresas WHERE bloqueado = 0";
		$empresas_activas = $sicuso->prepare($sql);
		$empresas_activas->execute();
	}
}




$sql = 'SELECT *  from sedes where estado = 1 AND id != 11';
$sedes_activas = $dbm->prepare($sql);
$sedes_activas->execute();
$sedes_activas = array_asociativo($sedes_activas);

// $disponibilidad_prof = array();
// $nombre_profesional = '';
// $disponibilidad_profesional = '{}';

//FILTRO
if ($formulario == "filtrar" || $formulario == "") {
	$comodin = '';

	if ($formulario == "") {
		$sede = 1;
		$fechaini_cita = $fecha_hoy;
		$fechafin_cita = date("Y-m-d", strtotime($fechaini_cita . " +30 days"));
		$comodin_cita_asignada = " AND a.fecha >= '" . $fechaini_cita . "' AND a.fecha <= '" . $fechafin_cita . "'  ";
		$comodin .= $comodin_cita_asignada;
	} else {
		$sede = variable_exterior("sede");
		$fechaini_cita = variable_exterior("fechaini_cita");
		$fechafin_cita = variable_exterior("fechafin_cita");
		$fechaini_crea = variable_exterior("fechaini_crea");
		$fechafin_crea = variable_exterior("fechafin_crea");
		$documento = variable_exterior("documento");
		$empresa_filtro = variable_exterior("empresa_filtro");
		$estado_filtro = variable_exterior("estado");
		$personal = variable_exterior("personal");

		//FECHA DE LA CITA
		$comodin_cita_asignada = "";
		if ($fechaini_cita != "" && $fechafin_cita != "") {
			$comodin_cita_asignada = " AND a.fecha >= '" . $fechaini_cita . "' AND a.fecha <= '" . $fechafin_cita . "'  ";
			$comodin .= $comodin_cita_asignada;
		}

		//FECHA DE LA CREACIÓN
		$comodin_cita_creada = "";
		if ($fechaini_crea != "" && $fechafin_crea != "") {
			$comodin_cita_creada = " AND a.fechasolicitud >= '" . $fechaini_crea . "' AND a.fechasolicitud <= '" . $fechafin_crea . "'  ";
			$comodin .= $comodin_cita_creada;
		}

		//DOCUMENTO DEL PCIENTE
		$comodin_documento = "";
		if ($documento != "") {
			$comodin_documento = " AND a.documento = '$documento'";
			$comodin .= $comodin_documento;
		}

		//EMPRESA
		$comodin_empresa = "";
		if ($empresa_filtro != "") {
			$comodin_empresa = " AND a.empresa LIKE '%" . $empresa_filtro . "%' ";
			$comodin .= $comodin_empresa;
		}

		//ESTADO
		$comodin_estado = "";
		if ($estado_filtro != "") {
			$comodin_estado = " AND a.estado LIKE '%" . $estado_filtro . "%' ";
			$comodin .= $comodin_estado;
		}

		//NOMBRE DEL USUARIO QUE REALIZÓ EL REGISTRO
		$comodin_personal = "";
		if ($personal != "") {
			$comodin_personal = " AND a.usuario = (SELECT nombre FROM usuarios WHERE cc_usuario = '$personal')";
			$comodin .= $comodin_personal;
		}
	}

	$conexiones_sedes_filtro = conectar_sicuso_sede($sede);

	//llenar CALENDARIO
	// $id_personal_buscar = $_SESSION['id_usuario'];
	if (!empty($conexiones_sedes_filtro)) {
		$agendas_totales = array(); // Arreglo para almacenar las agendas de todas las sedes

		foreach ($conexiones_sedes_filtro as $key => $conexion_filtro) {
			$nombre_sede = nombre_sede($key, $dbm);
			/* DESC SE AGREGA LA OBSERVACION CONCATENADA CON EL NOMBRE DE LA SEDE SOLO SI NO ES NULO ESE VALOR*/
			/* SERVICIO SE PUEDEN CAMBIAR LOS SIGNOS POR LOS QUE SE SEPARA EL SERVICIO*/
			$sql = "SELECT
						CONCAT(a.idagenda, ' - ', '$key') AS id,
						CONCAT(a.idagenda, ' - ', a.documento, ' - ', a.nombre, ' - ', a.empresa, ' - ', '$nombre_sede') AS title,
						a.inicio AS start,
						a.final AS end,
						'fc-event-success' as className,
						CONCAT('ESTADO: ', a.estado,' - ','OBSERVACIONES: ', IFNULL(a.observaciones, '')) AS description,
						REPLACE(cs.servicios_concatenados, ',', ' - ') AS location
					FROM
						agenda AS a
					LEFT JOIN (
						SELECT idagenda, GROUP_CONCAT(servicio) AS servicios_concatenados FROM citaservicios GROUP BY idagenda
					) AS cs ON a.idagenda = cs.idagenda
					WHERE
						1 = 1 $comodin AND CONCAT(a.documento, ' - ', a.nombre, ' - ', a.empresa, ' - ', '$nombre_sede') IS NOT NULL";

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

$sql_usuario = "SELECT numero_identificacion, nombre_completo FROM personal WHERE estado = 1";
$personal_usuarios = $dbm->prepare($sql_usuario);
$personal_usuarios->execute();

$sql = "SELECT * FROM personal WHERE id_procesos = '" . $_SESSION['id_procesos'] . "'";
$personal_creacion = $dbm->prepare($sql);
$personal_creacion->execute();
$personal_creacion = array_asociativo($personal_creacion);

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
