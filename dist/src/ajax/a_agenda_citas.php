<?php
include "../../seguridad/conexion.php";

// include "../functions/main.php";
include "../functions/email.php";
session_start();
$hora_actual = date("H:i:s");
$dbm_mysql = conectar_mysql();
$response = [];
$fecha_hora_hoy = date("Y-m-d H:i:s");
$fecha_hoy = date("Y-m-d");
$nombre_personal_sesion = $_SESSION['nombre_completo'];

// Verificar si la solicitud es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recibir los datos enviados por la solicitud POSenviar_emailT
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data['accion'] == "eliminar_cita") {
        $sede = id_sede(trim($data['sede']), $dbm_mysql);
        $conexion = conectar_sicuso_sede($sede);
        // var_dump($sede);
        if (!empty($conexion)) {
            foreach ($conexion as $key => $dbm_sicuso1) {
                // var_dump($conexion);
                $dbm = $dbm_sicuso1;
            }
        }
        // Ahora puedes acceder a los datos enviados
        $idagenda = trim($data['idagenda']); // Reemplaza 'key1' con el nombre de tu clave

        $sql = "UPDATE agenda SET estado = 'CANCELADA' WHERE idagenda = '$idagenda'";
        $query = $dbm->prepare($sql);
        if ($query->execute()) {
            $sql = "UPDATE ordenes SET estado = 'anulada',fecha_anulacion = '$fecha_hoy', hora_anulacion = '$hora_actual', anulo = '$nombre_personal_sesion', motivo = 'CANCELACION DE CITA'  WHERE idagenda = '$idagenda'";
            $query = $dbm->prepare($sql);
            if ($query->execute()) {
                $sql = "UPDATE facturas SET estado = 'anulada',fecha_anulacion = '$fecha_hoy', hora_anulacion = '$hora_actual', anulo = '$nombre_personal_sesion', motivo = 'CANCELACION DE CITA'  WHERE idagenda = '$idagenda'";
                $query = $dbm->prepare($sql);
                if ($query->execute()) {
                    $response = array('mensaje' => 'ok');
                } else {
                    $response = array('mensaje' => 'error');
                }
            } else {
                $response = array('mensaje' => 'error');
            }
        } else {
            $response = array('mensaje' => 'error');
        }
    }

    if ($data['accion'] == "consulta_paciente") {

        $sede = $data['sede'];
        $cc = trim($data['documento']);
        if ($cc  != "" && $data['sede'] != "") {

            $conexion = conectar_sicuso_sede($sede);
            if (!empty($conexion)) {
                foreach ($conexion as $key => $dbm_sicuso1) {
                    // var_dump($conexion);
                    $dbm = $dbm_sicuso1;
                }
            }
            $fecha_inicio = $data['fecha_inicio'];
            $fecha_fin = $data['fecha_fin'];
            $hora_inicio = $data['hora_inicio'] . ':00';
            $hora_fin = $data['hora_fin'] . ':00';

            $sql = "SELECT
                        COUNT(*) AS cont 
                    FROM
                        agenda A,
                        ordenes B 
                    WHERE
                        A.idagenda = B.idagenda 
                        AND B.estado = 'pre_facturada'
                        AND B.fechacita = '$fecha_inicio' 
                        AND A.hoarainicio = '$hora_inicio'";
            $citas_sede = $dbm->prepare($sql);
            $citas_sede->execute();
            $citas_sede = array_($citas_sede);

            $cantidad_citas_ocupadas_ensede = $citas_sede[0]['cont'];

            $sql = "SELECT cantidad FROM distribucioncitas WHERE hora = '$hora_inicio';";
            $distribucion_cita = $dbm->prepare($sql);
            $distribucion_cita->execute();
            $distribucion_cita = array_($distribucion_cita);

            if ($distribucion_cita) {
                $cantidad_citas_dispo_ensede = $distribucion_cita[0]['cantidad'];
                if ($cantidad_citas_ocupadas_ensede < $cantidad_citas_dispo_ensede) {
                    $disponibilidad_cita_sede = "si";
                } else {
                    $disponibilidad_cita_sede = "no";
                }
            } else {
                $disponibilidad_cita_sede = "no";
            }

            $sql = 'SELECT A.Municipio as municipio from listamunicipios A GROUP BY A.Municipio';
            $municipio = $dbm->prepare($sql);
            $municipio->execute();
            $municipio = array_($municipio);


            // encontrar paciente sicuso
            $sql = "SELECT * FROM pacientes where docidentificacion='$cc'";
            $paciente = $dbm->prepare($sql);
            $paciente->execute();
            $paciente = array_($paciente);

            if ($_SESSION['id_perfil'] == "CLIENTE") {
                $sql = "SELECT idempresa,empresa FROM empresas WHERE bloqueado = 0 AND empresa IN " . $empresas_asociadas . " ORDER BY empresa ASC";
                $empresa = $dbm->prepare($sql);
                $empresa->execute();
                $empresa = array_($empresa);
                $comodin_empresa = " AND b.empresa IN " . $empresas_asociadas . "";
            } else {
                $sql = 'SELECT idempresa,empresa FROM empresas WHERE bloqueado = 0 ORDER BY empresa ASC';
                $empresa = $dbm->prepare($sql);
                $empresa->execute();
                $empresa = array_($empresa);
                $comodin_empresa = "";
            }

            $nombre_sede = nombre_sede($sede, $dbm_mysql);
            $sql = "SELECT
                        b.fecha AS fecha,
                        b.idorden AS id_orden,
                        b.cargo AS cargo,
                        b.mision AS mision,
                        b.empresa AS empresa,
                        b.cita AS cita,
                        b.ciudadfactura AS ciudad,
                        b.rednacional AS red_nacional,
                        b.ordennumero AS ordennumero,
                        b.estado AS estadoOrden,
                        b.idagenda AS idagenda,
                        b.idorden AS idorden,
                        b.tipo AS tipo,
                        d.inicio AS fechacitacion,
                        '$nombre_sede' AS sede
                    FROM
                        pacientes a
                    LEFT JOIN ordenes b ON ( a.idpaciente = b.idpaciente )
                    LEFT JOIN agenda d ON ( b.idagenda = d.idagenda )
                    WHERE a.docidentificacion = '$cc'
                    $comodin_empresa
                    ORDER BY b.fecha DESC";
            $ordenes_paciente = $dbm->prepare($sql);
            $ordenes_paciente->execute();
            $ordenes_paciente = array_($ordenes_paciente); // Arreglo para almacenar las ordenes de una sede específica

            $response = array('paciente' => $paciente, 'empresas' => $empresa, 'disponibilidad_cita_sede' => $disponibilidad_cita_sede, 'municipio' => $municipio, 'ordenes_paciente' => $ordenes_paciente);
        }
    }

    if ($data['accion'] == "consultar_mision") {
        $sede = $data['sede'];
        $id_empresa = trim($data['id_empresa']);
        if ($id_empresa  != "" && $data['sede'] != "") {
            $conexion = conectar_sicuso_sede($sede);
            if (!empty($conexion)) {
                foreach ($conexion as $key => $dbm_sicuso1) {
                    // var_dump($conexion);
                    $dbm = $dbm_sicuso1;
                }
            }

            $sql = 'SELECT empresa FROM listaenmision WHERE idempresa="' . $id_empresa . '" ORDER BY empresa ASC';
            $enmision = $dbm->prepare($sql);
            $enmision->execute();
            $enmision = array_($enmision);

            $sql = 'SELECT nombre FROM mediautoriza WHERE idempresa="' . $id_empresa . '" ORDER BY nombre ASC';
            $autoriza = $dbm->prepare($sql);
            $autoriza->execute();
            $autoriza = array_($autoriza);

            $sql = 'SELECT * FROM empresas WHERE idempresa="' . $id_empresa . '"';
            $datos_fac = $dbm->prepare($sql);
            $datos_fac->execute();
            $datos_fac = array_($datos_fac);

            $sql = 'SELECT * FROM listaprecios WHERE idempresa="' . $id_empresa . '"';
            $servicios = $dbm->prepare($sql);
            $servicios->execute();
            $servicios = array_($servicios);



            $response = array("mision" => $enmision, "autoriza" => $autoriza, "datos_fac" => $datos_fac, "servicios" => $servicios);
        } else {
            $response = array('mensaje' => 'error');
        }
    }

    if ($data['accion'] == "generar_cita") {
        $fecha_hoy =  date("Y-m-d");
        $datos = $data['data'];
        // var_dump();
        $sede = $datos['calendar_event_name'];
        $conexion = conectar_sicuso_sede($sede);
        if (!empty($conexion)) {
            foreach ($conexion as $key => $dbm_sicuso1) {
                // var_dump($conexion);
                $dbm = $dbm_sicuso1;
            }
        } else {
            $response = array('resultado' => 'error_conexion', 'sede' => nombre_sede($sede, $dbm_mysql));
        }
        // var_dump($datos);    
        $paciente_nuevo = $datos['paciente_nuevo'];
        $docidentificacion = trim($datos['calendar_event_description']);
        $primernombre = strtoupper($datos['primernombre']);
        $segundonombre = strtoupper($datos['segundonombre']);
        $primerapellido = strtoupper($datos['primerapellido']);
        $segundoapellido = strtoupper($datos['segundoapellido']);
        $cargo = $datos['cargo'];
        $telefono = $datos['telefono'];
        $cajero = $datos['cajero'];
        $tipodoc = $datos['tipodoc'];
        $ciudadorigen = $datos['ciudadorigen'];
        $direccion = $datos['direccion'];
        $fechaingreso = $fecha_hoy;
        $fechanacimiento = $datos['fechanacimiento'];
        $sexo = $datos['sexo'];
        $empmision = $datos['enmision'];
        $diff = date_diff(date_create($fechanacimiento), date_create($fecha_hoy));
        $edad = $diff->format("%y%");
        $nombrecompleto = trim($primernombre) . ' ' . trim($segundonombre) . ' ' . trim($primerapellido) . ' ' . trim($segundoapellido);
        $tipoingreso = $datos['tipo'];
        $email = $datos['email'];
        $empresa = $datos['empresa_buscar'];
        $ciudadfactura = nombre_sede($sede, $dbm_mysql);
        $centroCosto = $datos['centrodecosto'];
        $centrooperaciones = $datos['centrooperaciones'];
        $autorizacion = $datos['autorizacion'];
        $requisicion = $datos['requisicion'];
        $ordenservicio = $datos['ordenservicio'];
        $id_responsable = $_SESSION['id_usuario'];
        $fecha_cita_orden_prefactura = $datos['calendar_event_start_date'];
        $hora_inicio = $datos['calendar_event_start_time'];
        $detalle = $datos["detalle"];
        $solicitante_cita = $datos['solicitante_cita'];
        $correo_alterno = $datos['correo_alterno'];
        $origen = $datos['origen'];
        $fecha_estimada_inicio = $datos['fecha_estimada_inicio'];
        $hora_estimada_inicio = $datos['hora_estimada_inicio'];
        $trabajos_especiales = "";
        foreach ($datos['tipocargo[]'] as $key => $value) {
            $trabajos_especiales .=  $value . ' , ';
        }
        $trabajos_especiales = trim($trabajos_especiales, ' , ');





        if ($paciente_nuevo == 'no') {
            $idpaciente = $datos['id_paciente'];
            $sql = 'UPDATE pacientes SET primernombre = "' . $primernombre . '", segundonombre = "' . $segundonombre . '",
			primerapellido = "' . $primerapellido . '", segundoapellido = "' . $segundoapellido . '",cargo = "' . $cargo . '", telefono = "' . $telefono . '",
			tipodoc = "' . $tipodoc . '", ciudadorigen = "' . $ciudadorigen . '", direccion = "' . $direccion . '",
			sexo = "' . $sexo . '",nombrecompleto = "' . $nombrecompleto . '" ,email = "' . $email . '" 
			WHERE idpaciente="' . $idpaciente . '"';
            $query = $dbm->prepare($sql);
            if ($query->execute()) {
                $paciente = 'oki';
            } else {
                $paciente = 'no';
                $response = array('resultado' => 'error_actu_paciente');
            }
        } else if ($paciente_nuevo == "si") {
            $data =
                [
                    'docidentificacion' => $docidentificacion, 'primernombre' => $primernombre, 'segundonombre' => $segundonombre,
                    'primerapellido' => $primerapellido, 'segundoapellido' => $segundoapellido, 'cargo' => $cargo, 'telefono' => $telefono,
                    'tipodoc' => $tipodoc, 'ciudadorigen' => $ciudadorigen, 'direccion' => $direccion, 'fechaingreso' => $fechaingreso,
                    'fechanacimiento' => $fechanacimiento, 'sexo' => $sexo, 'empmision' => $empmision, 'edad' => $edad, 'empleador' => $empresa,
                    'nombrecompleto' => $nombrecompleto, 'tipoingreso' => $tipoingreso, 'orden' => $orden, 'email' => $email
                ];
            $sql = 'INSERT INTO
						pacientes (docidentificacion,primernombre,segundonombre,primerapellido,segundoapellido,cargo,telefono,tipodoc,
						ciudadorigen,direccion,fechaingreso,fechanacimiento,sexo,empmision,edad,empleador,
						nombrecompleto,tipoingreso,orden,email
						)
					VALUES
						(:docidentificacion,:primernombre,:segundonombre,:primerapellido,:segundoapellido,:cargo,:telefono,:tipodoc,
						:ciudadorigen,:direccion,:fechaingreso,:fechanacimiento,:sexo,:empmision,:edad,:empleador,
						:nombrecompleto,:tipoingreso,:orden,:email				
						)';
            $query = $dbm->prepare($sql);
            if ($query->execute($data)) {
                $idpaciente = $dbm->lastInsertId();
                $paciente = 'ok';
            } else {
                $paciente = 'no';
                $response = array('resultado' => 'error_insert_paciente');
            }
        }

        if ($paciente == 'ok' || $paciente == 'oki' && $paciente != 'no') {
            $rednacional = 'no';
            $hora_inicio_prefactura = $hora_actual;
            $cajeroprefactura = $cajero;
            $fechaprefactura = $fecha_hoy;

            $data = [
                'fecha' => $fecha_hoy, 'hora' => $hora_actual, 'docidentificacion' => $docidentificacion, 'telefono' => $telefono,
                'cajero' => $cajero, 'estado' => 'pre_facturada', 'direccion' => $direccion, 'mision' => $empmision, 'tipo' => $tipoingreso,
                'nombre' => $nombrecompleto, 'empresa' => $empresa, 'idpaciente' => $idpaciente,
                'ciudadfactura' => $ciudadfactura, 'tipocargo' => $trabajos_especiales, 'rednacional' => $rednacional, 'centroCosto' => $centroCosto,
                'autorizacion' => $autorizacion, 'requisicion' => $requisicion, 'centrooperaciones' => $centrooperaciones,
                'ordenservicio' => $ordenservicio, 'lista' => 'no',
                'vencida' => 'no', 'cargo' => $cargo,
            ];

            $sql_orden = 'INSERT INTO
						  	ordenes (fecha,hora,docidentificacion,telefono,cajero,estado,direccion,mision,tipo,nombre,empresa,
						  	idpaciente,ciudadfactura,tipocargo,rednacional,centroCosto,autorizacion,requisicion,
						  	centrooperaciones,ordenservicio,lista,vencida,cargo
						  	)
						  VALUES
						  (	:fecha,:hora,:docidentificacion,:telefono,:cajero,:estado,:direccion,:mision,:tipo,:nombre,:empresa,
						  :idpaciente,:ciudadfactura,:tipocargo,:rednacional,:centroCosto,:autorizacion,:requisicion,
						  :centrooperaciones,:ordenservicio,:lista,:vencida,:cargo
						  )';
            $orden = $dbm->prepare($sql_orden);
            if ($orden->execute($data)) {
                $idorden = $dbm->lastInsertId();
                $orden = 'ok';
                if ($idorden) {
                    $sql = "SELECT * FROM empresas WHERE idempresa = '" . $empresa . "'  and bloqueado = 'no' LIMIT 1";
                    $nit_empresa = $dbm->prepare($sql);
                    $nit_empresa->execute();
                    $nit_empresa_datos = $nit_empresa->fetch();

                    $data = [
                        'docidentificacion' => $docidentificacion, 'telefono' => $telefono, 'estado' => 'pre_facturada', 'direccion' => $direccion,
                        'idordenexamen' => $idorden, 'idpaciente' => $idpaciente, 'empresa' => $empresa,
                        'cliente' => $nombrecompleto, 'ciudadfactura' => $ciudadfactura, 'mision' => $empmision, 'tipocargo' => $trabajos_especiales,
                        'centroCostos' => $centroCosto, 'autorizacion' => $autorizacion, 'ordenservicio' => $ordenservicio,
                        'requicision' => $requisicion, 'centrooperaciones' => $centrooperaciones, 'rednacional' => $rednacional,
                        'fechacita' => NULL, 'vencida' => 'no', 'lista' => 'no', 'tipo' => $tipoingreso,
                        'idorden' => $idorden, 'cajero' => $cajero, 'nit' => $nit_empresa_datos['codigo'], 'fecha' => $fecha_hoy, 'hora' => $hora_actual, 'horaprefactura' => $hora_inicio_prefactura, 'cajeroprefactura' => $cajeroprefactura, 'fechaprefactura' => $fechaprefactura,
                    ];
                    $sql_factura = 'INSERT INTO
							facturas (docidentificacion,telefono,estado,direccion,idordenexamen,idpaciente,empresa,
							cliente,ciudadfactura,mision,tipocargo,centroCostos,autorizacion,ordenservicio,requicision,
							centrooperaciones,rednacional,fechacita,vencida,lista,tipo,idorden,cajero,nit,fecha,hora,horaprefactura,cajeroprefactura,fechaprefactura
							)
						VALUES
							(	
								:docidentificacion,:telefono,:estado,:direccion,:idordenexamen,:idpaciente,:empresa,
								:cliente,:ciudadfactura,:mision,:tipocargo,:centroCostos,:autorizacion,:ordenservicio,:requicision,
								:centrooperaciones,:rednacional,:fechacita,:vencida,:lista,:tipo,:idorden,:cajero,:nit,:fecha,:hora,:horaprefactura,:cajeroprefactura,:fechaprefactura
							)';
                    $factura = $dbm->prepare($sql_factura);
                    if ($factura->execute($data)) {
                        $idfactura = $dbm->lastInsertId();
                        $sql = 'select numeracion from ordenesnumeracion;';
                        $orden_consecutivo = $dbm->prepare($sql);
                        if ($orden_consecutivo->execute()) {

                            $consecutivo = $orden_consecutivo->fetch();
                            $act_consecutivo = $consecutivo[0] + 1;
                            $sql_ordennumero_update = "UPDATE ordenesnumeracion SET numeracion=" . $act_consecutivo;
                            $orden_update = $dbm->prepare($sql_ordennumero_update);
                            $orden_update->execute();

                            // Traer prefijo de ciudad
                            $sql_prefijo = "select prefijociudad from configuracioninterna";
                            $prefijo = $dbm->prepare($sql_prefijo);
                            $prefijo->execute();

                            $prefijoorden = $prefijo->fetch();

                            $sql_fact_update = "UPDATE facturas SET  ordennumero='" . $prefijoorden[0] . $consecutivo[0] . "' , empresa = '" . $nit_empresa_datos['empresa'] . "' WHERE idfactura='$idfactura' ";
                            $orden_update = $dbm->prepare($sql_fact_update);
                            $orden_update->execute();

                            $sql_orden_update = "UPDATE ordenes SET idfactura='$idfactura' , ordennumero='" . $prefijoorden[0] . $consecutivo[0] . "', empresa = '" . $nit_empresa_datos['empresa'] . "' WHERE idorden='$idorden' ";
                            $orden_update_orden = $dbm->prepare($sql_orden_update);
                            $orden_update_orden->execute();
                            if ($orden_update->execute()) {
                                // AGREGAR LOS SERVICIOS A LA FACTURA


                                //GENERAR CITA MEDIANTE LA PREFACTURA 
                                if ($fecha_cita_orden_prefactura != "" && $hora_inicio  != "") {

                                    $fecha_cita_real_1 = $fecha_cita_orden_prefactura;
                                    $hora_cita_inicio_1 = $hora_inicio . ':00';

                                    $fecha_inicio_cita = "$fecha_cita_real_1 $hora_cita_inicio_1";
                                    $nuevaFecha = date("Y-m-d H:i:s", strtotime($fecha_inicio_cita) + (20 * 60));

                                    $hora_cita_fin_1 = explode(" ", $nuevaFecha)[1];

                                    $hora_citacion = date("g:i:s a", strtotime($hora_cita_inicio_1));
                                    $hora_fin_citacion = date("g:i:s a", strtotime($hora_cita_fin_1));
                                    $fecha_fin_cita = "$fecha_cita_real_1 $hora_fin_citacion";

                                    $sql = "INSERT INTO agenda (
													color,
													caption,
													image,
													hoarainicio,
													horafinal,
													notas,
													titulo,
													fecha,
													nombre,
													horacitacion,
													empresa,
													documento,
													telefono,
													estado,
													observaciones,
													pruebas,
													solicitante,
													correo,
													usuario,
													cargo,
													fechasolicitud,
													fechasolicitada,
													fechaasignada,
													inicio,
													final,
													primernombre,
													segundonombre,
													primerapellido,
													segundoapellido,
													tipoexamen,
													mision,
													concepto_trabajo_esp,
													centroCosto,
													centrooperaciones,
													ordendeservicio,
													requisicion,
													medio 
												)
												VALUES
													(
														16777215,
														'Nueva Tarea',
														- 1,
														'$hora_cita_inicio_1',
														'$hora_cita_fin_1',
														'nombre: $nombrecompleto ',
														'Nueva Cita',
														'$fecha_cita_real_1',
														'$nombrecompleto',
														'$hora_citacion',
														'$empresa',
														'$docidentificacion',
														'$telefono',
														'PENDIENTE',
														'$detalle',
														0,
														'$solicitante_cita',
														'$correo_alterno',
														'$cajero',
														'$cargo',
														'$fecha_hoy',
														'$fecha_hoy',
														'$fecha_cita_real_1',
														'$fecha_inicio_cita',
														'$nuevaFecha	',
														'$primernombre',
														'$segundonombre',
														'$primerapellido',
														'$segundoapellido',
														'$tipoingreso',
														'$empmision',
														'$trabajos_especiales',
														'$centroCosto',
														'$centrooperaciones',
														'$ordenservicio',
														'$requisicion',
														'SICUSO.COM - $origen' 
													);";
                                    // var_dump($sql);
                                    // die;
                                    $agenda_cita = $dbm->prepare($sql);
                                    // echo $sql_req;
                                    if ($agenda_cita->execute()) {
                                        $id_ultimo = $dbm->lastInsertId();
                                        $sql = "UPDATE ordenes SET idagenda = '$id_ultimo', fechacita = '$fecha_cita_real_1', cita = '$hora_citacion' WHERE idorden = '$idorden'";
                                        $query = $dbm->prepare($sql);
                                        // echo $sql_req;
                                        if ($query->execute()) {
                                            $sql = "UPDATE facturas SET cita = '$hora_citacion', `fechacita` = '$fecha_cita_real_1', idagenda = '$id_ultimo' WHERE idorden = '$idorden'";
                                            $query = $dbm->prepare($sql);
                                            if ($query->execute()) {
                                            } else {
                                                $response = array('resultado' => 'error_actu_facturas');
                                            }
                                        } else {
                                            $response = array('resultado' => 'error_actu_ordenes');
                                        }
                                    } else {
                                        $response = array('resultado' => 'error_insert_agenda');
                                    }
                                } else {
                                    $response = array('resultado' => 'error_cita');
                                }

                                $c = 0;
                                $c2 = 0;
                                $a2 = "";
                                foreach ($datos['servicios[]'] as $key => $value) {
                                    $c++;
                                    // procesar los servicios
                                    $id_lista_precio = explode('/', $value)[0];
                                    $valor_empresa = explode('/', $value)[1];
                                    $servicio = explode('/', $value)[2];
                                    $tiposervicio = explode('/', $value)[3];
                                    $grupo = explode('/', $value)[4];
                                    $codigo = explode('/', $value)[5];

                                    $a2 .= $servicio . ' , ';
                                    if ($valor_empresa == "0") {
                                        $valor_empresa = valor_particular($servicio, $dbm);
                                        if ($valor_empresa == "0") {
                                            $response = array('resultado' => 'sin_precio', 'servicio' => $servicio);
                                        }
                                    }
                                    if ($valor_empresa != "0") {
                                        $data = [
                                            "idfactura" => $idfactura,
                                            "servicio" => $servicio,
                                            "cantidad" => '1',
                                            "paga" => 'Empresa',
                                            "valor" => $valor_empresa,
                                            "tiposervicio" => $tiposervicio,
                                            "fecha" => $fecha_hoy,
                                            "cobro" => 'Cobro Corporativo',
                                            "grupo" => $grupo,
                                            "codigo" => $codigo,
                                            "facturado" => 'NO',
                                            "validared" => 'no',
                                            "validado" => 'no',
                                        ];
                                        $sql = "INSERT INTO facturas_items
                                                    (idfactura, servicio, cantidad, paga, valor, tiposervicio, fecha, cobro, grupo, codigo, facturado,validared, validado)
                                                VALUES
                                                    (:idfactura, :servicio, :cantidad, :paga, :valor, :tiposervicio, :fecha, :cobro, :grupo, :codigo, :facturado,:validared, :validado)";
                                        $facturas_items = $dbm->prepare($sql);
                                        if ($facturas_items->execute($data)) {
                                            $sql_insert = "INSERT INTO citaservicios (idagenda, servicio, paga) VALUES ('$id_ultimo', '$servicio', 'Empresa');";
                                            $query = $dbm->prepare($sql_insert);
                                            if ($query->execute()) {
                                                $c2++;
                                            }
                                        }
                                    }
                                }
                                $title = $id_ultimo . ' - ' . $docidentificacion . ' - ' . $nombrecompleto . ' - ' . $nit_empresa_datos['empresa'] . ' - ' . nombre_sede($sede, $dbm_mysql);
                                $description = 'ESTADO: PENDIENTE - OBSERVACIONES: ' . $detalle;
                                $location = trim($a2, ' , ');
                                $idcalendar = $id_ultimo . ' - ' . $sede;
                                if ($c == $c2) {
                                    if ($_SESSION['id_perfil'] == "CLIENTE") {
                                        $id_tipo_requerimiento = tipo_requerimiento_x_proceso('Gestión de prefacturas', $_SESSION['id_procesos'], $dbm_intranet);
                                        $id_categoria_requerimiento = categoria_requerimiento('Nueva prefactura', $id_tipo_requerimiento, $dbm_intranet);
                                    } else {
                                        $id_tipo_requerimiento = 23;
                                        $id_categoria_requerimiento = 127;
                                        $id_procesos = 25;
                                        $detalle_req = $detalle . ' , ' . 'Detalle de la cita : Documento identificación: ' . $docidentificacion . ' Nombre Completo :' . $nombrecompleto . ',
							 					Empresa ' . $nit_empresa_datos['empresa'] . ', En Misión: ' . $empmision . ' , 
							 					Cargo: ' . $cargo . ', Telefono de Contacto: ' . $telefono . ', 
							 					Tipo de Examen : ' . $tipoingreso . ', Trabajos Especiales: ' . $trabajos_especiales . ', Ciudad: ' . nombre_sede($sede, $dbm_mysql) . ', Orden: ' . $prefijoorden[0] . $consecutivo[0] . ', Servicios: ' . $location;

                                        $sql = "SELECT
                                                    municipio 
                                                FROM
                                                    sedes,
                                                    municipios 
                                                WHERE
                                                    sedes.id_municipios = municipios.id_municipio
                                                    AND sedes.id = '$sede'";
                                        $query = $dbm_mysql->prepare($sql);
                                        $query->execute();
                                        $ciudad_sede = array_($query);

                                        $fecha_estimada_inicio = $fecha_estimada_inicio . ' ' . $hora_estimada_inicio;
                                        $fecha_hora_hoy = date("Y-m-d H:i:s");
                                        $sql = "INSERT INTO requerimientos
                                                        ( id_procesos, id_tipo, detalle, prioridad, estado, fecha_estimada_entrega, fecha_solicitado,
                                                        id_personal_solicitado, origen, id_requerimientos_categoria,fecha_asignado,id_personal_asignado, 
                                                        fecha_estimada_inicio,email_alterno, detalle_asignado, 
                                                        id_personal_aperturado,id_personal_gestion, id_personal_entregado, id_personal_finalizado, 
                                                        fecha_aperturado, fecha_gestion , fecha_entregado, fecha_finalizado, calificacion, empresa, 
                                                        sede, ciudad, cantidad, id_terceros, clase, orden, id_sede)
                                                        VALUES
                                                            ( '" . $id_procesos . "', '$id_tipo_requerimiento', '$detalle_req', 'ALTA', 'FINALIZADO', '', '$fecha_hoy',
                                                             $id_responsable, '$origen', '$id_categoria_requerimiento', '$fecha_hora_hoy',$id_responsable,
                                                             '$fecha_estimada_inicio','$correo_alterno', 'AutoRequerimiento - Calendario Citas',
                                                             '$id_responsable','$id_responsable','$id_responsable','$id_responsable', 
                                                             '$fecha_hora_hoy','$fecha_hora_hoy','$fecha_hora_hoy','$fecha_hora_hoy', '3', '" . $nit_empresa_datos['empresa'] . "', 
                                                             '" . nombre_sede($sede, $dbm_mysql) . "', '" . $ciudad_sede[0]['municipio'] . "', '1', '0', 'Cliente', '$idorden', '$sede')";
                                        $query = $dbm_mysql->prepare($sql);
                                        if ($query->execute()) {
                                            $id_ultimo_requerimiento = $dbm->lastInsertId();
                                            $data = [
                                                'id_requerimientos' => $id_ultimo_requerimiento,
                                                'tipo' => "Creación Requerimiento",
                                                'fecha' => $fecha_hora_hoy,
                                                'detalle' => "Se realiza la radicacion del Nuevo requerimiento con ID°" . $id_ultimo_requerimiento,
                                                'id_personal' => $id_responsable,
                                                'icono' => "flaticon2-shield text-",
                                                'color' => "danger",
                                            ];
                                            $sql = "INSERT INTO requerimientos_bitacora
                                                        (id_requerimientos, tipo, fecha, detalle, id_personal, icono, color) 
                                                    VALUES 
                                                        (:id_requerimientos, :tipo, :fecha, :detalle, :id_personal, :icono, :color)";
                                            $query = $dbm_mysql->prepare($sql);
                                            if ($query->execute($data)) {
                                                $data = [
                                                    'id_requerimientos' => $id_ultimo_requerimiento,
                                                    'tipo' => "Creación Requerimiento",
                                                    'fecha' => $fecha_hora_hoy,
                                                    'detalle' => "Se realiza la generación de una nueva cita para la sede de: " . nombre_sede($sede, $dbm_mysql) . ' con identificación : ' . $docidentificacion,
                                                    'id_personal' => $id_responsable,
                                                    'icono' => "flaticon2-shield text-",
                                                    'color' => "danger",
                                                ];
                                                $sql = "INSERT INTO requerimientos_bitacora
                                                            (id_requerimientos, tipo, fecha, detalle, id_personal, icono, color) 
                                                        VALUES 
                                                            (:id_requerimientos, :tipo, :fecha, :detalle, :id_personal, :icono, :color)";
                                                $query = $dbm_mysql->prepare($sql);
                                                if ($query->execute($data)) {
                                                    $sql = "SELECT * FROM datosempresa";
                                                    $datos_empresa = $dbm->prepare($sql);
                                                    $datos_empresa->execute();
                                                    $datos_empresa = array_($datos_empresa);

                                                    $array_datos[] = [
                                                        'documento' => $docidentificacion,
                                                        'nombrecompleto' => $nombrecompleto,
                                                        'sede' => nombre_sede($sede, $dbm_mysql),
                                                        'cargo' => $cargo,
                                                        'empresa' => $nit_empresa_datos['empresa'],
                                                        'mision' => $empmision,
                                                        'tipo' => $tipoingreso,
                                                        'tipocargo' => $trabajos_especiales,
                                                        'direccion' => $datos_empresa[0]['direccion'],
                                                        'telefono' => $datos_empresa[0]['telefonos'],
                                                        'observacion' => $detalle,
                                                        'servicios' =>  trim($a2, ' , '),
                                                        'fechacita' => $fecha_cita_orden_prefactura . ' ' . $hora_inicio . ':00',
                                                        'id_requerimiento' => $id_ultimo_requerimiento
                                                    ];

                                                    // ENVIAR CORREO A VARIOS CORREOS -  EMPRESA
                                                    if ($datos['correo_empresa'] != "") {
                                                        $array = explode(";", $datos['correo_empresa']);
                                                        for ($i = 0; $i < count($array); $i++) {
                                                            if ($array[$i] != "") {
                                                                enviar_email($array[$i], 'empresa', $array_datos, $dbm_mysql);
                                                            }
                                                        }
                                                    }

                                                    // ENVIAR CORREO A VARIOS CORREOS -  EMPRESA
                                                    if ($datos['correo_uso'] != "") {
                                                        $array = explode(";", $datos['correo_uso']);
                                                        for ($i = 0; $i < count($array); $i++) {
                                                            if ($array[$i] != "") {
                                                                enviar_email($array[$i], 'ips', $array_datos, $dbm_mysql);
                                                            }
                                                        }
                                                    }

                                                    enviar_email($email, 'paciente', $array_datos, $dbm_mysql);

                                                    $response = array('resultado' => 'ok', 'title' => $title, 'description' => $description, 'location' => $location, 'idcalendar' => $idcalendar, 'fecha' => $fecha_cita_orden_prefactura, 'hora_inicio' => $hora_inicio, 'orden' => $idorden, 'sede' => $sede);
                                                } else {
                                                    $response = array('resultado' => 'error_bitacora2_req');
                                                }
                                            } else {
                                                $response = array('resultado' => 'error_bitacora1_req');
                                            }
                                        } else {
                                            $response = array('resultado' => 'error_req');
                                        }
                                    }
                                }
                            } else {
                                $response = array('resultado' => 'error_no_guardado');
                            }
                        }
                    }
                }
            }
        } else {
            $response = array('resultado' => 'error_paciente');
        }
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

function nombre_sede($id, $dbm)
{
    $respuesta = "";

    $sql = "SELECT nombre FROM sedes WHERE id = '" . $id . "'";
    $query = $dbm->prepare($sql);
    $query->execute();
    while ($fila = $query->fetch()) {
        $respuesta =  $fila[0];
    }

    return $respuesta;
}

function id_sede($nombre, $dbm)
{
    $respuesta = "";

    $sql = "SELECT id FROM sedes WHERE nombre = '$nombre'";
    $query = $dbm->prepare($sql);
    $query->execute();
    while ($fila = $query->fetch()) {
        $respuesta =  $fila[0];
    }

    return $respuesta;
}

function valor_particular($servicio, $dbm)
{

    $respuesta = "";
    $sql = "SELECT valor_empresa FROM listaprecios WHERE empresa = 'PARTICULAR' AND servicio = '$servicio' ";
    $query = $dbm->prepare($sql);
    $query->execute();
    while ($fila = $query->fetch()) {
        $respuesta =  $fila[0];
    }

    return $respuesta;
}

//EMPRESA - PREFACTURA
function enviar_email(
    $envia_correo,
    $tipo,
    $array,
    $dbm_mysql
) {

    $envio_correo = enviar_mail_cita_web(
        $envia_correo,
        $tipo,
        $array
    );

    $tipo_email = "Cita Confirmada";
    $fecha_hora_hoy = date("Y-m-d H:i:s");

    if ($envio_correo == "Envio Correo Satisfactorio!" && $envia_correo != "") {
        $data = [
            'id_requerimientos' => $array[0]['id_requerimiento'],
            'tipo' => $tipo_email,
            'fecha' => $fecha_hora_hoy,
            'detalle' => "Se realiza el envio de email con la novedad registrada en el requerimiento ID°" . $array[0]['id_requerimiento'] . ', enviado al correo de la ips: ' . $envia_correo,
            'id_personal' => $_SESSION["id_usuario"],
            'icono' => "flaticon2-paperplane text-",
            'color' => "success",
        ];
        $sql = "INSERT INTO requerimientos_bitacora(id_requerimientos, tipo, fecha, detalle, id_personal, icono, color) VALUES (:id_requerimientos, :tipo, :fecha, :detalle, :id_personal, :icono, :color)";
        $query = $dbm_mysql->prepare($sql);
        $query->execute($data);
    } else {
        $data = [
            'id_requerimientos' => $array[0]['id_requerimiento'],
            'tipo' => $tipo_email,
            'fecha' => $fecha_hora_hoy,
            'detalle' => "ERROR en el envio de email con la novedad registrada en el requerimiento ID°" . $array[0]['id_requerimiento'] . ", por favor verificar correo del destinatario " . $envia_correo,
            'id_personal' => $_SESSION["id_usuario"],
            'icono' => "flaticon2-warning text-",
            'color' => "danger",
        ];
        $sql = "INSERT INTO requerimientos_bitacora(id_requerimientos, tipo, fecha, detalle, id_personal, icono, color) VALUES (:id_requerimientos, :tipo, :fecha, :detalle, :id_personal, :icono, :color)";
        $query = $dbm_mysql->prepare($sql);
        $query->execute($data);
    }
}
