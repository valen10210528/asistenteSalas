	<!--end::Head-->
	<div class="row g-5 g-xl-8">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title fw-bolder">Calendar</h2>
					<div class="card-toolbar">

						<button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
							<span class="svg-icon svg-icon-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
								</svg>
							</span>
							Filtro
						</button>

						<div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px " data-kt-menu="true" id="kt-toolbar-filter">
							<!--begin::Header-->
							<div class="px-7 py-5">
								<div class="fs-4 text-dark fw-bolder">Opciones de Filtros</div>
							</div>
							<!--begin::Separator-->
							<div class="separator border-gray-200"></div>
							<div class="max-height-300px overflow-y-auto scroll-y mh-325px"> <!-- Agregar estas clases -->

								<form class="form" action="?url_id=agenda_citas" method="POST" id="filtrar" name="filtrar">
									<div class="px-7 py-5">
										<div class="mb-10">
											<label class="form-label fs-5 fw-bold mb-3 required">Seleccionar Sede:</label>
											<select required class="form-select form-select-solid fw-bolder " data-kt-select2="true" data-placeholder="Seleccione Sede" data-allow-clear="true" data-kt-customer-table-filter="sede" id="sede" name="sede" data-dropdown-parent="#kt-toolbar-filter">
												<option value="" selected> Seleccione Sede</option>
												<?php
												// while ($fila = $sedes_activas->fetch()) {
												foreach ($sedes_activas as $fila) {
													# code...
												?>
													<option value="<? echo $fila['id'] ?>"><? echo $fila['nombre']; ?></option>
												<?php
												}
												?>
												<option value="999">TODAS LAS SEDES</option>
											</select>
										</div>

										<div class="mb-10">
											<label class="form-label fs-5 fw-bold mb-3 ">Seleccionar Empresa:</label>
											<select class="form-select form-select-solid fw-bolder " data-kt-select2="true" data-placeholder="Seleccione Empresa" data-allow-clear="true" data-kt-customer-table-filter="empresa_filtro" id="empresa_filtro" name="empresa_filtro" data-dropdown-parent="#kt-toolbar-filter">
												<option value="" selected> Seleccione Empresa</option>
												<?php
												while ($fila = $empresas_activas->fetch()) {
												?>
													<option value="<? echo $fila['empresa'] ?>"><? echo $fila['empresa']; ?></option>
												<?php
												}
												?>
											</select>
										</div>

										<div class="mb-10">
											<label class="form-label fs-5 fw-bold mb-3 ">Seleccionar Estado:</label>
											<select class="form-select form-select-solid fw-bolder " data-kt-select2="true" data-placeholder="Seleccione Estado" data-allow-clear="true" data-kt-customer-table-filter="estado" id="estado" name="estado" data-dropdown-parent="#kt-toolbar-filter">
												<option value="" selected> Seleccione Estado</option>
												<option value="pen">PENDIENTE</option>
												<option value="asi">ASISTIÓ</option>
												<option value="con">CONFIRMADA</option>
											</select>
										</div>

										<div class="mb-10">
											<label class="form-label fs-5 fw-bold mb-3 ">Personal que creó el registro:</label>
											<select class="form-select form-select-solid fw-bolder " data-kt-select2="true" data-placeholder="Seleccione Personal" data-allow-clear="true" data-kt-customer-table-filter="personal" id="personal" name="personal" data-dropdown-parent="#kt-toolbar-filter">
												<option value="" selected> Seleccione Personal</option>
												<?php
												while ($fila = $personal_usuarios->fetch()) {
												?>
													<option value="<?php echo $fila['numero_identificacion'] ?>"><?php echo $fila['nombre_completo']; ?></option>
												<?php
												}
												?>

											</select>
										</div>

										<div class="form-group mb-6">
											<div class="mb-0">
												<label class="form-label">Documento</label>
												<input id="documento" name="documento" type="text" class="form-control form-control-solid" placeholder="Documento" id="kt_daterangepicker_3" />
											</div>
										</div>
										<h5 align="center">Fecha de la cita</h5>
										<div class="form-group mb-6">
											<div class="mb-0">
												<label class="form-label">Inicial</label>
												<input id="fechaini_cita" name="fechaini_cita" type="date" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_3" />
											</div>
										</div>
										<div class="form-group mb-6">
											<div class="mb-0">
												<label class="form-label">Final</label>
												<input id="fechafin_cita" name="fechafin_cita" type="date" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_3" />
											</div>
										</div>
										<h5 align="center">Fecha de creación</h5>
										<div class="form-group mb-6">
											<div class="mb-0">
												<label class="form-label">Inicial</label>
												<input id="fechaini_crea" name="fechaini_crea" type="date" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_3" />
											</div>
										</div>
										<div class="form-group mb-6">
											<div class="mb-0">
												<label class="form-label">Final</label>
												<input id="fechafin_crea" name="fechafin_crea" type="date" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_3" />
											</div>
										</div>

										<div class="d-flex justify-content-end">
											<input type="submit" name="enviar" class="btn btn-primary" value="Filtrar">
											<input type="hidden" name="formulario" id="formulario" value="filtrar">
										</div>

									</div>

								</form>
							</div>
						</div>
						<button class="btn btn-flex btn-primary" data-kt-calendar="add">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
							<span class="svg-icon svg-icon-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
									<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
								</svg>
							</span>
							Add Event
						</button>
					</div>
				</div>

				<!--end::Card header-->
				<!--begin::Card body-->
				<div class="card-body">
					<!--begin::Calendar-->
					<div id="kt_calendar_app"></div>
					<!--end::Calendar-->
				</div>
				<!--end::Card body-->
			</div>
			<!--end::Card-->
			<!--begin::Modals-->
			<!--begin::Modal - New Product-->
			<div class="modal fade " id="kt_modal_add_event" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
				<!--begin::Modal dialog-->
				<div class="modal-dialog modal-xl">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Form-->
						<form class="form" action="#" id="kt_modal_add_event_form">
							<!--begin::Modal header-->
							<div class="modal-header">
								<!--begin::Modal title-->
								<h2 class="fw-bolder" data-kt-calendar="title">Generar Cita</h2>
								<!--end::Modal title-->
								<!--begin::Close-->
								<div class="btn btn-icon btn-sm btn-active-icon-primary" id="kt_modal_add_event_close">
									<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
									<span class="svg-icon svg-icon-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
											<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
										</svg>
									</span>
									<!--end::Svg Icon-->
								</div>
								<!--end::Close-->
							</div>
							<!--end::Modal header-->
							<!--begin::Modal body-->
							<div class="modal-body py-10 px-lg-17">

								<div class="row row-cols-lg-2 g-10">
									<div class="col">
										<div class="fv-row mb-9">
											<label class="fs-6 fw-bold required mb-2">Sede:</label>
											<!-- <input type="text" class="form-control form-control-solid" placeholder="" name="calendar_event_name" /> -->
											<select class="form-select form-select-solid fw-bolder" data-placeholder="Select option" id="kt_modal_add_event_sede_paciente" name="calendar_event_name">
												<option value="" selected>Seleccionar Sede </option>
												<?php
												foreach ($sedes_activas as $fila) {
												?>
													<option value="<? echo $fila['id'] ?>"><? echo $fila['nombre']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="col">
										<div class="fv-row mb-9">
											<label class="fs-6 fw-bold mb-2 required">Documento:</label>
											<input class="form-control form-control-solid" min="0" placeholder="Documento Paciente" type="text" id="kt_modal_add_event_cedula_paciente" name="calendar_event_description">
										</div>
									</div>
								</div>



								<div class="fv-row mb-9" style="display: none;">
									<input type="text" class="form-control form-control-solid" placeholder="" name="calendar_event_location" />
								</div>
								<div class="fv-row mb-9" style="display: none;">
									<label class="form-check form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" value="" id="kt_calendar_datepicker_allday" style="display: none;" />
									</label>
								</div>

								<div class="row row-cols-lg-4 g-10">
									<div class="col">
										<div class="fv-row mb-9">
											<!--begin::Label-->
											<label class="fs-6 fw-bold mb-2 required">Fecha Cita</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input class="form-control form-control-solid" name="calendar_event_start_date" placeholder="Pick a start date" id="kt_calendar_datepicker_start_date" />
											<!--end::Input-->
										</div>
									</div>
									<div class="col">
										<div class="fv-row mb-9">
											<!--begin::Label-->
											<label class="fs-6 fw-bold mb-2 required">Inicio cita</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input class="form-control form-control-solid" name="calendar_event_start_time" placeholder="Pick a start time" id="kt_calendar_datepicker_start_time" />
											<!--end::Input-->
										</div>
									</div>
									<div class="col" style="display: none;">
										<div class="fv-row mb-9">
											<!--begin::Label-->
											<label class="fs-6 fw-bold mb-2 required">Fin cita</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input class="form-control form-control-solid" name="calendar_event_end_time" placeholder="Pick a end time" id="kt_calendar_datepicker_end_time" />
											<!--end::Input-->
										</div>
									</div>
									<div class="col">
										<div class="fv-row mb-9">
											<label class="form-label fs-5 fw-bold my-3 "></label>
											<br>
											<button type="button" id="kt_modal_add_event_submit_doc" class="btn btn-primary">
												<span class="indicator-label">Revisar disponibilidad</span>
												<span class="indicator-progress">Please wait...
													<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											</button>
										</div>
									</div>
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="row row-cols-lg-2 g-10" style="display: none;">
									<div class="col">
										<div class="fv-row mb-9">
											<!--begin::Label-->
											<label class="fs-6 fw-bold mb-2 required">Event End Date</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input class="form-control form-control-solid" name="calendar_event_end_date" placeholder="Pick a end date" id="kt_calendar_datepicker_end_date" />
											<!--end::Input-->
										</div>
									</div>
								</div>


								<!-- FORMULARIO DE PROCESAMIENTO DE LA ORDEN O CITA -->
								<div style="display: none;" id="crear_orden" name="crear_orden">

									<!-- PARTE DE REQUERIMIENTO -->
									<?
									if ($_SESSION['id_perfil'] != "CLIENTE") {
									?>
										<fieldset>
											<div class="mb-9 my-2 d-flex flex-center">
												<div class="badge badge-lg badge-light-primary d-inline">Datos Requerimiento</div>
											</div>
											<div class="row my-2">
												<div class="col-lg-6">
													<div class="form-group mb-6">
														<label class="form-label required fs-5 fw-bold mb-3">Origen Solicitud</label>
														<select required class="form-control border-0 form-control-solid text-muted font-size-lg font-weight-bolder pl-5 min-h-50px" id="origen" name="origen" required>
															<option value="" selected="selected">Origen de Solicitud</option>
															<option value="WEB">WEB</option>
															<option value="WHATSAPP">WHATSAPP</option>
															<option value="PBX">PBX</option>
															<option value="PRESENCIAL">PRESENCIAL</option>
															<option value="CORREO">CORREO</option>
															<option value="CELULAR">CELULAR</option>
															<option value="AUTOGESTION">AUTOGESTION</option>
															<option value="VIRTUAL">VIRTUAL</option>
														</select>
													</div>
												</div>
												<div class="col-lg-6">
													<label class="form-label fs-5 fw-bold mb-3 required">Fecha Requerimiento:</label>

													<div class="row">
														<div class="col-6">
															<input required max="<?= date('Y-m-d') ?>" class="form-control form-control-solid" type="date" name="fecha_estimada_inicio" id="fecha_estimada_inicio">
														</div>
														<div class="col - 6">
															<input required class="form-control form-control-solid" type="time" name="hora_estimada_inicio" id="hora_estimada_inicio">
														</div>
													</div>


												</div>
											</div>
											<div class="row my-2">
												<div class="col-lg-6">
													<label class="fs-5 fw-bold col-6 required">Responsable </label>
													<select class="form-control form-control-solid" required name="cajero" id="cajero" required>
														<option value="" selected disabled> Seleccione </option>
														<?php
														if (isset($personal_creacion)) {
															foreach ($personal_creacion as $fila) {
																if ($fila['numero_identificacion'] == $_SESSION['numero_identificacion']) {
														?>
																	<option selected data-id='<?= $fila['id']; ?>' value="<?= $fila['nombre_completo'] ?>"><?= $fila['nombre_completo'] ?></option>
																<?php
																} else {
																?>
																	<option data-id='<?= $fila['id']; ?>' value="<?= $fila['nombre_completo'] ?>"><?= $fila['nombre_completo'] ?></option>
														<?php
																}
															}
														}
														?>
													</select>
													<input type="hidden" value="<?= $_SESSION['id_usuario'] ?>" name="id_responsable" id="id_responsable">
												</div>
												<div class="col-lg-6">
													<div class="form-group mb-6">
														<label class="required fs-5 fw-bold ">Correo Origen Solicitud</label>
														<input required class="form-control form-control-solid mb-8" type="text" id="correo_alterno" name="correo_alterno" onkeyup="espacios_coma('correo_alterno')">
													</div>
												</div>
											</div>

											<div class="row my-2">
												<div class="col-lg-12">
													<label class="fs-5 fw-bold">Observaciones / Comentarios</label>
													<textarea name="detalle" id="detalle" cols="30" rows="2" class="form-control border-0 form-control-solid text-muted font-size-lg font-weight-bolder pl-5 min-h-50px"></textarea>
												</div>
											</div>
											<div class="row my-2">
												<div class="col col-sm-6 my-2">
													<div class="form-group mb-6">
														<input id="archivo[]" name="archivo[]" type="file" class="form-control form-control-sm dropzone-select btn btn-light-primary font-weight-bold btn-sm" data-show-upload="true" data-show-caption="true" multiple>
													</div>
												</div>
												<div class="col col-sm-6 my-2">
													<div class="form-group mb-6">
														<select class="form-control form-control-solid" name="solicitante_cita" id="solicitante_cita">
															<option value="" disabled> Seleccione </option>
															<option value="Empresa" selected> Empresa </option>
															<option value="Paciente"> Paciente </option>
															<option value="Particular"> Particular </option>
														</select>
													</div>
												</div>
											</div>
										</fieldset>
									<?
									} else {
									?>
										<input type="hidden" id="origen" name="origen" value="WEB - CLIENTE">
										<input type="hidden" id="fecha_estimada_inicio" name="fecha_estimada_inicio" value="<?= $fecha_hoy ?>">
										<input type="hidden" id="hora_estimada_inicio" name="hora_estimada_inicio" value="<?= $hora_actual ?>">
										<input type="hidden" id="correo_alterno" name="correo_alterno" value="<?= $_SESSION['email'] ?>">
										<input type="hidden" id="cajero" name="cajero" value="<?= $_SESSION['nombre_completo'] ?>">
										<input type="hidden" id="solicitante_cita" name="solicitante_cita" value="empresa">
										<input id="archivo[]" name="archivo[]" type="hidden" value="">
									<?
									}
									?>
									<br><br>
									<!-- DATOS DEL PACIENTE -->
									<fieldset>
										<div class="mb-9 my-2 d-flex flex-center">
											<div class="badge badge-lg badge-light-primary d-inline">Datos Paciente</div>
										</div>
										<div class="row my-2">
											<div class="col-lg-4">
												<label class="fs-5 fw-bold required">Tipo de Documento</label>
												<select name="tipodoc" required class="form-control form-control-solid" id="tipodoc">
													<option value=''> Seleccione</option>
													<option value='CEDULA'> CEDULA</option>
													<option value='CEDULA EXTRANJERIA'> CEDULA EXTRANJERIA</option>
													<option value='OTRO'> OTRO</option>
													<option value='PASAPORTE'> PASAPORTE</option>
													<option value='REGISTRO CIVIL'> REGISTRO CIVIL</option>
													<option value='TARJETA IDENTIDAD'> TARJETA IDENTIDAD</option>
												</select>
											</div>
											<div class="col-lg-4">
												<label class="fs-5 fw-bold ">Ciudad Documento</label>
												<select name="ciudadorigen" id="ciudadorigen" class="form-control form-control-solid">
													<option value=''> Seleccione</option>
												</select>
											</div>
											<div class="col-lg-4">
												<label class="fs-5 fw-bold" for="">Fecha Nacimiento</label>
												<input type="date" min='1900-01-01' class="form-control form-control-solid" name="fechanacimiento" id="fechanacimiento">
											</div>
										</div>
										<div class="row my-2">
											<div class="col-lg-3">
												<label class="required fs-5 fw-bold ">Primer Nombre</label>
												<input required type="text" class="form-control form-control-solid" name="primernombre" id="primernombre">
											</div>
											<div class="col-lg-3">
												<label class="fs-5 fw-bold ">Segundo Nombre</label>
												<input type="text" class="form-control form-control-solid" name="segundonombre" id="segundonombre">
											</div>
											<div class="col-lg-3">
												<label class="required fs-5 fw-bold ">Primer Apellido</label>

												<input required type="text" class="form-control form-control-solid" name="primerapellido" id="primerapellido">
											</div>
											<div class="col-lg-3">
												<label class="fs-5 fw-bold ">Segundo Apellido</label>

												<input type="text" class="form-control form-control-solid" name="segundoapellido" id="segundoapellido">
											</div>
										</div>
										<div class="row my-2">
											<div class="col-lg-6">
												<label class="fs-5 fw-bold col-6" for="">Email</label>
												<input type="email" class="form-control form-control-solid" name="email" id="email">
											</div>
											<div class="col-lg-6">
												<label class="fs-5 fw-bold col-6" for="">Sexo</label>
												<select name="sexo" id="sexo" class="form-control form-control-solid">
													<option value="" selected disabled>Seleccione </option>
													<option value="FEMENINO">FEMENINO</option>
													<option value="MASCULINO">MASCULINO</option>
												</select>
											</div>

										</div>
										<div class="row my-2">
											<div class="col-lg-6">
												<label class="fs-5 fw-bold col-6">Dirección</label>

												<input type="text" class="form-control form-control-solid" name="direccion" id="direccion">
											</div>

											<div class="col-lg-6">
												<label class="fs-5 fw-bold col-6">Teléfono</label>

												<input type="text" class="form-control form-control-solid" name="telefono" id="telefono">
											</div>
										</div>
									</fieldset>

									<br>
									<br>
									<!-- INICIO ORDENES DEL PACIENTE -->
									<div class="mb-9 my-2 d-flex flex-center">
										<div id="orden_paciente_label" class="badge badge-lg badge-light-primary">Ordenes del paciente</div>
									</div>
									<fieldset>
										<div class="row my-2">
											<div class="col-lg-12">
												<div class="table-responsive">
													<table class="table align-middle table-row-dashed fs-6 gy-5" id="table_ordenes_paciente">
														<thead>
															<tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
																<th class="max-w-40" style="visibility:collapse; display:none;">Dias</th>
																<th class="min-w-125px">Orden</th>
																<!-- <th class="min-w-125px">Sede</th> -->
																<th class="max-w-105px">Fecha Creación</th>
																<th class="max-w-105px">Origen</th>
																<th class="max-w-105px">Cita</th>
																<th class="max-w-105px">Estado</th>
																<th class="max-w-185px">Empresa</th>
																<th class="max-w-105px">Tipo / Cargo</th>
															</tr>
														</thead>
														<tbody class="fw-bold text-gray-600" id="ordenes_paciente">

														</tbody>
													</table>
												</div>
											</div>
										</div>

									</fieldset>
									<hr>
									<!-- FIN ORDENES DEL PACIENTE -->
									<br><br>
									<!-- DATOS EMPRESA -->
									<fieldset>
										<div class="mb-9 my-2 d-flex flex-center">
											<div class="badge badge-lg badge-light-primary d-inline">Datos Empresa</div>
										</div>
										<div class="row my-2">
											<div class="col-lg-6">
												<label class="required fs-5 fw-bold col-6">Cargo</label>
												<input required type="text" class="form-control form-control-solid" name="cargo" id="cargo">
											</div>
										</div>
										<input type="text" id="paciente_nuevo" name="paciente_nuevo" style="display: none;">
										<input type="text" id="id_paciente" name="id_paciente" style="display: none;">

										<div class="row my-2">
											<div class="col-lg-6">
												<label class="fs-5 fw-bold required">Empresa</label>
												<select required class="form-control form-control-solid" name="empresa_buscar" id="empresa_buscar">
													<option value="" selected disabled>Seleccione </option>
												</select>
												<!-- <input type="hidden" class="form-control form-control-solid" name="empresa" id="empresa"> -->
											</div>
											<div class="col-lg-6">
												<label class="fs-5 fw-bold required">Empresa En Misión</label>
												<select required class="form-control form-control-solid" name="enmision" id="enmision">
													<option value="Ninguna" selected>Ninguna </option>
												</select>
											</div>
										</div>
										<div class="row my-2">
											<div class="col-lg-6">
												<label class="fs-5 fw-bold required">Trabajos Especiales</label>
												<select class="form-select form-select-solid js-example-basic-multiple" required name="tipocargo[]" id="tipocargo" data-control="select2" data-close-on-select="false" data-placeholder="Seleccione " data-allow-clear="true" multiple="multiple">
													<option id="no_aplica_trabajo_especial" value="No Aplica">No Aplica
													<option>
													<option value="Alta Tensión">Alta Tensión
													<option>
													<option value="Altas Temperaturas">Altas Temperaturas
													<option>
													<option value="Altitudes Mayores a 2500 Metros">Altitudes Mayores a 2500 Metros
													<option>
													<option value="Ambientes Hiperbáricos">Ambientes Hiperbáricos
													<option>
													<option value="Brigadista">Brigadista
													<option>
													<option value="Conducción de Vehículos">Conducción de Vehículos
													<option>
													<option value="Espacios Confinados">Espacios Confinados
													<option>
													<option value="Manipulación Sustancias Químicas">Manipulación Sustancias Químicas
													<option>
													<option value="Manipulador de alimentos">Manipulador de alimentos
													<option>
													<option value="Trabajo en alturas ">Trabajo en alturas
													<option>
													<option value="Radiaciones Ionizantes">Radiaciones Ionizantes
													<option>
													<option value="Trabajo de bajas Temperaturas">Trabajo de bajas Temperaturas
													<option>
												</select>
											</div>
											<div class="col-lg-6">
												<label class="fs-5 fw-bold col-6 required">Tipo de Exámen</label>
												<select class="form-control form-control-solid" name="tipo" required id="tipo" required>
													<option value="" selected disabled> Seleccione </option>
													<option value='PREINGRESO'> PREINGRESO</option>
													<option value='REINGRESO'> REINGRESO</option>
													<!-- <option value='INGRESO'> INGRESO</option> -->
													<option value='EGRESO'> EGRESO</option>
													<option value='CONFIRMATORIO'> CONFIRMATORIO</option>
													<option value='PERIODICO'> PERIODICO</option>
													<option value='POS INCAPACIDAD'> POS INCAPACIDAD</option>
													<option value='ESTUDIO CASO'> ESTUDIO CASO</option>
													<option value='PERIODICO CAMBIO DE CARGO'> PERIODICO CAMBIO DE CARGO</option>
													<option value='CONSULTA ASEGURABILIDAD'> CONSULTA ASEGURABILIDAD</option>
													<option value='PERIODICO PRIORITARIO'> PERIODICO PRIORITARIO</option>
												</select>
											</div>
										</div>
										<div class="row my-2">
											<div class="col-lg-3">
												<label class="fs-5 fw-bold col-6" id="label_centrodecosto">C.Costo</label>
												<input required type="text" class="form-control form-control-solid" name="centrodecosto" id="centrodecosto">

											</div>
											<div class="col-lg-3">
												<label class="fs-5 fw-bold col-6" id="label_centrooperaciones">C.Operaciones</label>
												<input required type="text" class="form-control form-control-solid" name="centrooperaciones" id="centrooperaciones">

											</div>
											<div class="col-lg-3">
												<label class="fs-5 fw-bold col-6" id="label_ordenservicio">Orden Servicio</label>
												<input required type="text" class="form-control form-control-solid" name="ordenservicio" id="ordenservicio">

											</div>
											<div class="col-lg-3">
												<label class="fs-5 fw-bold col-6" id="label_requisicion">Requisición</label>
												<input required type="text" class="form-control form-control-solid" name="requisicion" id="requisicion">

											</div>
										</div>
										<div class="row my-2">
											<div class="col-lg-12">
												<label class="fs-5 fw-bold col-6" id="label_autorizacion">Autorización </label>
												<select class="form-control form-control-solid" name="autorizacion" id="autorizacion" required>
													<option value="" selected disabled> Seleccione </option>
													<option value="No Aplica">No Aplica</option>
												</select>
											</div>
										</div>
									</fieldset>

									<br><br>
									<fieldset>
										<div class="mb-9 my-2 d-flex flex-center">
											<div class="badge badge-lg badge-light-primary d-inline">Servicios a agendar</div>
										</div>
										<div class="row my-2">
											<div class="col-lg-12">
												<label class="required fs-5 fw-bold col-6">Servicios</label>
												<select required class="form-select form-select-solid js-example-basic-multiple" name="servicios[]" id="servicios" data-control="select2" multiple="multiple" data-placeholder="No aplica" value="NO">
												</select>
											</div>
										</div>
									</fieldset>

									<br><br>
									<fieldset>
										<div class="mb-9 my-2 d-flex flex-center">
											<div class="badge badge-lg badge-light-primary d-inline">Enviar correos</div>
										</div>
										<div class="row my-2">
											<div class="col-lg-6">
												<label class="required fs-5 fw-bold col-6">Correo Empresa</label>
												<input required type="text" class="form-control form-control-solid" name="correo_empresa" id="correo_empresa" onkeyup="espacios_coma('correo_empresa')">
											</div>
											<div class="col-lg-6">
												<label class="required fs-5 fw-bold col-6">Correo USO</label>
												<input required type="text" class="form-control form-control-solid" name="correo_uso" id="correo_uso" value="citas@unidadso.com.co" onkeyup="espacios_coma('correo_uso')">
											</div>
										</div>
									</fieldset>
								</div>
							</div>
							<div class="modal-footer flex-center">
								<button type="reset" id="kt_modal_add_event_cancel" class="btn btn-light me-3">Cancelar</button>
								<button type="button" id="kt_modal_add_event_submit" class="btn btn-primary">
									<span class="indicator-label">Generar Cita</span>
									<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
						</form>
						<!--end::Form-->
					</div>
				</div>
			</div>
			<!--end::Modal - New Product-->
			<!--begin::Modal - New Product-->
			<div class="modal fade" id="kt_modal_view_event" tabindex="-1" aria-hidden="true">
				<!--begin::Modal dialog-->
				<div class="modal-dialog modal-dialog-centered mw-650px">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Modal header-->
						<div class="modal-header border-0 justify-content-end">
							<!--begin::Edit-->
							<div class="btn btn-icon btn-sm btn-color-gray-400 btn-active-icon-primary me-2" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit Event" id="kt_modal_view_event_edit" style="display: none;">
								<span class="svg-icon svg-icon-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
										<path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
									</svg>
								</span>
							</div>
							<!--end::Edit-->
							<!--begin::Edit-->
							<div class="btn btn-icon btn-sm btn-color-gray-400 btn-active-icon-danger me-2" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Delete Event" id="kt_modal_view_event_delete">
								<!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
								<span class="svg-icon svg-icon-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
										<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
										<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
							<!--end::Edit-->
							<!--begin::Close-->
							<div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-bs-toggle="tooltip" title="Hide Event" data-bs-dismiss="modal">
								<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
								<span class="svg-icon svg-icon-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
										<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
							<!--end::Close-->
						</div>
						<!--end::Modal header-->
						<!--begin::Modal body-->
						<div class="modal-body pt-0 pb-20 px-lg-17">
							<!--begin::Row-->
							<div class="d-flex">
								<!--begin::Icon-->
								<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
								<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Clipboard-list.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3" />
											<path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000" />
											<rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1" />
											<rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1" />
											<rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1" />
											<rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1" />
											<rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1" />
											<rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1" />
										</g>
									</svg><!--end::Svg Icon-->
								</span>
								<!--end::Svg Icon-->
								<!--end::Icon-->
								<div class="mb-9">
									<!--begin::Event name-->
									<div class="d-flex align-items-center mb-2">
										<span class="fs-3 fw-bolder me-3" data-kt-calendar="event_name"></span>
										<span class="badge badge-light-success" data-kt-calendar="all_day"></span>
									</div>
									<!--end::Event name-->
									<!--begin::Event description-->
									<div class="fs-6" data-kt-calendar="event_description"></div>
									<!--end::Event description-->
								</div>
							</div>
							<!--end::Row-->
							<!--begin::Row-->
							<div class="d-flex align-items-center mb-2">
								<!--begin::Icon-->
								<!--begin::Svg Icon | path: icons/duotune/abstract/abs050.svg-->
								<span class="svg-icon svg-icon-1 svg-icon-success me-5">
									<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<circle fill="#000000" cx="12" cy="12" r="8" />
									</svg>
								</span>
								<!--end::Svg Icon-->
								<!--end::Icon-->
								<!--begin::Event start date/time-->
								<div class="fs-6">
									<span class="fw-bolder">Inicio: </span>
									<span data-kt-calendar="event_start_date"></span>
								</div>
								<!--end::Event start date/time-->
							</div>
							<!--end::Row-->
							<!--begin::Row-->
							<div class="d-flex align-items-center mb-9">
								<!--begin::Icon-->
								<!--begin::Svg Icon | path: icons/duotune/abstract/abs050.svg-->
								<span class="svg-icon svg-icon-1 svg-icon-danger me-5">
									<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<circle fill="#000000" cx="12" cy="12" r="8" />
									</svg>
								</span>
								<!--end::Svg Icon-->
								<!--end::Icon-->
								<!--begin::Event end date/time-->
								<div class="fs-6">
									<span class="fw-bolder">Fin: </span>
									<span data-kt-calendar="event_end_date"></span>
								</div>
								<!--end::Event end date/time-->
							</div>
							<!--end::Row-->
							<!--begin::Row-->
							<div class="d-flex align-items-center">
								<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Star.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon points="0 0 24 0 24 24 0 24" />
											<path d="M12,18 L7.91561963,20.1472858 C7.42677504,20.4042866 6.82214789,20.2163401 6.56514708,19.7274955 C6.46280801,19.5328351 6.42749334,19.309867 6.46467018,19.0931094 L7.24471742,14.545085 L3.94038429,11.3241562 C3.54490071,10.938655 3.5368084,10.3055417 3.92230962,9.91005817 C4.07581822,9.75257453 4.27696063,9.65008735 4.49459766,9.61846284 L9.06107374,8.95491503 L11.1032639,4.81698575 C11.3476862,4.32173209 11.9473121,4.11839309 12.4425657,4.36281539 C12.6397783,4.46014562 12.7994058,4.61977315 12.8967361,4.81698575 L14.9389263,8.95491503 L19.5054023,9.61846284 C20.0519472,9.69788046 20.4306287,10.2053233 20.351211,10.7518682 C20.3195865,10.9695052 20.2170993,11.1706476 20.0596157,11.3241562 L16.7552826,14.545085 L17.5353298,19.0931094 C17.6286908,19.6374458 17.263103,20.1544017 16.7187666,20.2477627 C16.5020089,20.2849396 16.2790408,20.2496249 16.0843804,20.1472858 L12,18 Z" fill="#000000" />
										</g>
									</svg>
								</span>
								<div class="fs-6" data-kt-calendar="event_location"></div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<!--end::Modal - New Product-->
			<!--end::Modals-->
		</div>
		<!--end::Container-->
	</div>
	<!-- <script>
		var hostUrl = "assets/";
	</script> -->
	<!-- <script src="assets/plugins/global/plugins.bundle.js"></script> -->

	<!-- <script src="assets/js/custom/widgets.js"></script>
	<script src="assets/js/custom/apps/chat/chat.js"></script>
	<script src="assets/js/custom/modals/create-app.js"></script>
	<script src="assets/js/custom/modals/upgrade-plan.js"></script> -->