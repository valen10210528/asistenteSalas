<link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>


<script>
    function espacios_coma(input) {
        var x = document.getElementById(input);
        x.value = x.value.replace(' ', ';');
    }
</script>

<script>
    "use strict";
    var KTAppCalendar = function() {
        var prueba;
        var table_ordenes_paciente = '';
        var isClickEventAttached = false;
        var e, t, n, a, o, r, i, l, d, s, c, m, u, v, f, p, y, D, _, _2, b, k, g, S, Y, h, T, M, w, E, L, x = {
                id: "",
                eventName: "",
                eventDescription: "",
                eventLocation: "",
                startDate: "",
                endDate: "",
                allDay: !1
            },
            B = !1;
        const q = e => {
                C();
                const n = x.allDay ? moment(x.startDate).format("Do MMM, YYYY") : moment(x.startDate).format("Do MMM, YYYY - h:mm a"),
                    a = x.allDay ? moment(x.endDate).format("Do MMM, YYYY") : moment(x.endDate).format("Do MMM, YYYY - h:mm a");
                var o = {
                    container: "body",
                    trigger: "manual",
                    boundary: "window",
                    placement: "auto",
                    dismiss: !0,
                    html: !0,
                    title: "Reserva Agendada",
                    content: '<div class="fw-bolder mb-2">' + x.eventName + '</div><div class="fs-7"><span class="fw-bold" ><b>Inicio:</b></span> ' + n + '</div><div class="fs-7 mb-4"><span class="fw-bold" style="color: #bb2d3b"><b>Fin:</b></span> ' + a + '</div><div id="kt_calendar_event_view_button" type="button" class="btn btn-sm btn-light-primary">View More</div>'
                };
                (t = KTApp.initBootstrapPopover(e, o)).show(), B = !0, F()
            },
            C = () => {
                B && (t.dispose(), B = !1)
            },
            N = () => {
                f.innerText = "Generar Reserva", v.show();
                n.value = "";
                a.value = "";
                var t = p.querySelectorAll('[data-kt-calendar="datepicker"]'),
                    r = p.querySelector("#kt_calendar_datepicker_allday");
                O(x)

            },
            A = () => {
                var e, t, n;

                w.show(),
                    x.allDay ?
                    (e = "All Day", t = moment(x.startDate).format("Do MMM, YYYY"), n = moment(x.endDate).format("Do MMM, YYYY")) : (e = "", t = moment(x.startDate).format("Do MMM, YYYY - h:mm a"), n = moment(x.endDate).format("Do MMM, YYYY - h:mm a")), g.innerText = x.eventName, S.innerText = e, Y.innerText = x.eventDescription ? x.eventDescription : "--", h.innerText = x.eventLocation ? x.eventLocation : "--", T.innerText = t, M.innerText = n
            },
            H = () => {
                E.addEventListener("click", (t => {
                    t.preventDefault(), w.hide(), (() => {
                        f.innerText = "Edit an Event", v.show();
                        const t = p.querySelectorAll('[data-kt-calendar="datepicker"]'),
                            r = p.querySelector("#kt_calendar_datepicker_allday");
                        O(x), _.addEventListener("click", (function(t) {
                            t.preventDefault(), y && y.validate().then((function(t) {
                                console.log("validated!"), "Valid" == t ? (_.setAttribute("data-kt-indicator", "on"),
                                    _.disabled = !0,
                                    setTimeout((function() {
                                        _.removeAttribute("data-kt-indicator"), Swal.fire({
                                            text: "New event added to calendar!",
                                            icon: "success",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        }).then((function(t) {
                                            if (t.isConfirmed) {
                                                v.hide(), _.disabled = !1, e.getEventById(x.id).remove();
                                                let t = !1;
                                                r.checked && (t = !0), 0 === c.selectedDates.length && (t = !0);
                                                var l = moment(i.selectedDates[0]).format(),
                                                    s = moment(d.selectedDates[d.selectedDates.length - 1]).format();
                                                if (!t) {
                                                    const e = moment(i.selectedDates[0]).format("YYYY-MM-DD"),
                                                        t = e;
                                                    l = e + "T" + moment(c.selectedDates[0]).format("HH:mm:ss"), s = t + "T" + moment(u.selectedDates[0]).format("HH:mm:ss")
                                                }
                                                e.addEvent({
                                                    id: V(),
                                                    title: n.value,
                                                    description: a.value,
                                                    location: o.value,
                                                    start: l,
                                                    end: s,
                                                    allDay: t
                                                }), e.render(), p.reset()
                                            }
                                        }))
                                    }), 2e3)) : Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })
                            }))
                        }))
                    })()
                }))
            },
            F = () => {
                document.querySelector("#kt_calendar_event_view_button").addEventListener("click", (e => {
                    e.preventDefault(), C(), A()
                }))
            },
            O = () => {
                n.value = x.eventName ? x.eventName : "", a.value = x.eventDescription ? x.eventDescription : "", o.value = x.eventLocation ? x.eventLocation : "", i.setDate(x.startDate, !0, "Y-m-d");
                const e = x.endDate ? x.endDate : moment(x.startDate).format();
                d.setDate(e, !0, "Y-m-d");
                const t = p.querySelector("#kt_calendar_datepicker_allday"),
                    r = p.querySelectorAll('[data-kt-calendar="datepicker"]');
                x.allDay ? (t.checked = !0, r.forEach((e => {
                    e.classList.add("d-none")
                }))) : (c.setDate(x.startDate, !0, "Y-m-d H:i"), u.setDate(x.endDate, !0, "Y-m-d H:i"), d.setDate(x.startDate, !0, "Y-m-d"), t.checked = !1, r.forEach((e => {
                    e.classList.remove("d-none")
                })))
            },
            P = e => {
                x.id = e.id, x.eventName = e.title, x.eventDescription = e.description, x.eventLocation = e.location, x.startDate = e.startStr, x.endDate = e.endStr, x.allDay = e.allDay
            },
            V = () => Date.now().toString() + Math.floor(1e3 * Math.random()).toString();
        return {
            init: function() {
                // VARIABLES DEL MODAL

                const t = document.getElementById("kt_modal_add_event"); //NOMBRE DEL MODAL
                p = t.querySelector("#kt_modal_add_event_form"), //NOMBRE DEL FORMULARIO
                    n = p.querySelector('[name="calendar_event_name"]'),
                    a = p.querySelector('[name="calendar_event_description"]'),
                    o = p.querySelector('[name="calendar_event_location"]'),
                    r = p.querySelector("#kt_calendar_datepicker_start_date"),
                    l = p.querySelector("#kt_calendar_datepicker_end_date"),
                    s = p.querySelector("#kt_calendar_datepicker_start_time"),
                    m = p.querySelector("#kt_calendar_datepicker_end_time"),
                    D = document.querySelector('[data-kt-calendar="add"]'),
                    _ = p.querySelector("#kt_modal_add_event_submit_doc"),
                    _2 = p.querySelector("#kt_modal_add_event_submit"),
                    b = p.querySelector("#kt_modal_add_event_cancel"),
                    k = t.querySelector("#kt_modal_add_event_close"),
                    f = p.querySelector('[data-kt-calendar="title"]');
                v = new bootstrap.Modal(t);


                const B = document.getElementById("kt_modal_view_event");
                var F, O, I, R, G, K;
                prueba = _.addEventListener("click", (function(t) {
                    // console.log(n.value);
                    // console.log(a.value);
                    // console.log(isClickEventAttached);
                    t.preventDefault();
                    y && y.validate().then((function(t) {
                        if ("Valid" == t) {
                            const currentA = n.value; // Cambiar a n.value en lugar de a.value
                            const currentN = a.value;
                            fetch('src/ajax/a_agenda_reservas.php', {
                                    method: 'POST', // O 'GET' u otro método según tu necesidad
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        accion: 'consulta_paciente',
                                        documento: currentN,
                                        sede: currentA,
                                        fecha_inicio: r.value,
                                        fecha_fin: l.value,
                                        hora_inicio: s.value,
                                        hora_fin: m.value,
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {

                                    const ordenesWeb = data.ordenes_paciente;

                                    // LLENAR LA TABLA DE LAS ORDENES VIEJAS DEL PACIENTE
                                    if (table_ordenes_paciente != "") {
                                        table_ordenes_paciente.destroy();
                                    }

                                    document.getElementById('ordenes_paciente').innerHTML = "";


                                    $.each(ordenesWeb, function(id, value) {
                                        // Obtener la fecha actual
                                        if (value.red_nacional == "si") {
                                            value.sede = "CALI";
                                        } else if (value.sede == "CALI") {
                                            value.sede = "CALI NORTE"
                                        }

                                        if (value.sede == "BUENAVENTU") {
                                            value.sede = "BUENAVENTURA"
                                        }

                                        var boton = '<td> <a href="?url_id=orden_sede_detalle&sede=' + value.sede + '&id=' + value.id_orden + '"class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary" target="_blank">' + value.ordennumero + '</a> </td>';
                                        var botonlink = '<td> <a href="?url_id=orden_sede_detalle&sede=' + value.sede + '&id=' + value.id_orden + '"class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary" target="_blank">' + value.ordennumero + '</a> </td>';

                                        var fechaActual = new Date();
                                        // Convertir la fecha de citación a objeto Date
                                        if (value.fechacitacion != null && value.fechacitacion != undefined) {
                                            var fechaCitacion = new Date(value.fechacitacion);
                                            // Calcular la diferencia en milisegundos entre las fechas
                                            var diferenciaEnMilisegundos = Math.abs(fechaCitacion - fechaActual);

                                            // Calcular la cantidad de días de diferencia
                                            var diasDiferencia = Math.floor(diferenciaEnMilisegundos / (1000 * 60 * 60 * 24));
                                        }
                                        var filaHTML = '<tr>';
                                        filaHTML += '<td class="ocultar-columna">' + diasDiferencia + '</td>';
                                        if (diasDiferencia >= 7 && diasDiferencia != undefined) {
                                            // Si la diferencia es igual o mayor a 7| días, añadir la clase para resaltar la fila
                                            filaHTML += botonlink;

                                        } else {

                                            filaHTML += boton;
                                        }
                                        // filaHTML += '<td>' + value.sede + '</td>';
                                        filaHTML += '<td>' + value.fecha + '</td>';
                                        filaHTML += '<td>' + ((value.estadoOrden === 'pre_facturada' && value.idagenda != null ? "Cita" : "Prefactura")) + '</td>';
                                        filaHTML += '<td>' + (value.fechacitacion === null ? "No Aplica" : value.fechacitacion) + '</td>';
                                        filaHTML += '<td>' + value.estadoOrden + '</td>';
                                        filaHTML += '<td class="max-w-185">' + value.empresa + ' / ' + value.mision + '</td>';
                                        filaHTML += '<td>' + value.tipo + ' / ' + value.cargo + '</td>';
                                        filaHTML += '</tr>';

                                        $("#ordenes_paciente").append(filaHTML);
                                    });

                                    // Inicializar DataTable si aún no existe
                                    table_ordenes_paciente = new DataTable('#table_ordenes_paciente', {
                                        // destroy: true,

                                        responsive: true,
                                        columnDefs: [{
                                            targets: [0], // Índice de la columna de días (contando desde 0)
                                            visible: false, // Ocultar la columna de días
                                        }],
                                        "createdRow": function(row, data, dataIndex) {
                                            if (data[0] >= 7) {
                                                $(row).addClass('red');
                                            }
                                        },
                                        "destroy": true // Destruir instancia previa de DataTable si existe
                                    });

                                    /* FIN LLENAR LA TABLA DE LAS ORDENES VIEJAS DEL PACIENTE */

                                    const startInput = document.getElementById('kt_calendar_datepicker_start_time');
                                    const endInput = document.getElementById('kt_calendar_datepicker_end_time');

                                    // Agrega un oyente de eventos para el evento 'input' en el primer input
                                    startInput.addEventListener('input', function() {
                                        document.getElementById('crear_orden').style.display = 'none';

                                        // Obtiene el valor actual del primer campo de entrada
                                        const startValue = startInput.value;

                                        // Verifica si el valor es una hora válida en el formato HH:MM
                                        const timeRegex = /^([01]\d|2[0-3]):([0-5]\d)$/;
                                        if (timeRegex.test(startValue)) {
                                            // Divide la hora y los minutos en partes separadas
                                            const [hours, minutes] = startValue.split(':');

                                            // Convierte las horas y minutos a números enteros
                                            const hoursInt = parseInt(hours, 10);
                                            const minutesInt = parseInt(minutes, 10);

                                            // Suma 20 minutos a los minutos actuales
                                            const newMinutes = (minutesInt + 20) % 60;

                                            // Calcula las horas adicionales si los minutos superan 60
                                            const additionalHours = Math.floor((minutesInt + 20) / 60);

                                            // Suma las horas actuales y las adicionales
                                            const newHours = (hoursInt + additionalHours) % 24;

                                            // Formatea la nueva hora y minutos en el formato HH:MM
                                            const newTime = `${String(newHours).padStart(2, '0')}:${String(newMinutes).padStart(2, '0')}`;

                                            // Actualiza el valor del segundo campo de entrada con la nueva hora
                                            endInput.value = newTime;
                                        }
                                    });


                                    if (data.disponibilidad_cita_sede != "si") {
                                        Swal.fire({
                                            text: "No hay disponibilidad para la hora de inicio seleccionada.",
                                            icon: "warning",
                                        });
                                    } else {
                                        document.getElementById('crear_orden').style.display = 'block';

                                        // MUNICIPIOS
                                        var municipios = data.municipio;
                                        var select = document.getElementById("ciudadorigen");
                                        for (var i = 0; i < municipios.length; i++) {
                                            var option = document.createElement("option"); // Crea un elemento option
                                            if (municipios[i].municipio !== null) {
                                                option.value = municipios[i].municipio; // Establece el valor de la opción
                                                option.text = municipios[i].municipio; // Establece el texto visible de la opción
                                                select.appendChild(option); // Agrega la opción al select
                                            }
                                        }
                                        // EMPRESA
                                        var empresas_2 = data.empresas;
                                        var select_2 = document.getElementById("empresa_buscar");
                                        for (var i = 0; i < empresas_2.length; i++) {
                                            var option = document.createElement("option"); // Crea un elemento option
                                            option.value = empresas_2[i].idempresa; // Establece el valor de la opción
                                            option.text = empresas_2[i].empresa; // Establece el texto visible de la opción
                                            select_2.appendChild(option); // Agrega la opción al select
                                        }


                                        // CONSULTAR LAS MISIONES
                                        select_2.addEventListener("change", function() {
                                            // Aquí puedes ejecutar código cuando el valor del select cambie
                                            var id_empresa = select_2.value;
                                            document.getElementById("requisicion").value = "";
                                            document.getElementById("centrooperaciones").value = "";
                                            document.getElementById("centrodecosto").value = "";
                                            document.getElementById("ordenservicio").value = "";

                                            document.getElementById("requisicion").removeAttribute("required");
                                            document.getElementById("centrooperaciones").removeAttribute("required");
                                            document.getElementById("centrodecosto").removeAttribute("required");
                                            document.getElementById("ordenservicio").removeAttribute("required");


                                            document.getElementById("label_requisicion").classList.remove("required");;
                                            document.getElementById("label_centrooperaciones").classList.remove("required");;
                                            document.getElementById("label_centrodecosto").classList.remove("required");;
                                            document.getElementById("label_ordenservicio").classList.remove("required");;


                                            // document.getElementById("tipo").selectedIndex = 0;
                                            // document.getElementById("tipocargo").selectedIndex = 0;

                                            fetch('src/ajax/a_agenda_reservas.php', {
                                                    method: 'POST', // O 'GET' u otro método según tu necesidad
                                                    headers: {
                                                        'Content-Type': 'application/json'
                                                    },
                                                    body: JSON.stringify({
                                                        accion: 'consultar_mision',
                                                        id_empresa: id_empresa,
                                                        sede: currentA
                                                    })
                                                })
                                                .then(response => response.json())
                                                .then(data => {

                                                    if (data.datos_fac[0].centrocostos == "1") {
                                                        document.getElementById("centrodecosto").setAttribute("required", "required");
                                                        document.getElementById("label_centrodecosto").classList.add("required");
                                                    }

                                                    if (data.datos_fac[0].ordenservicio == "1") {
                                                        document.getElementById("ordenservicio").setAttribute("required", "required");
                                                        document.getElementById("label_ordenservicio").classList.add("required");
                                                    }

                                                    if (data.datos_fac[0].requisicion == "1") {
                                                        document.getElementById("requisicion").setAttribute("required", "required");
                                                        document.getElementById("label_requisicion").classList.add("required");
                                                    }

                                                    if (data.datos_fac[0].centrooperaciones == "1") {
                                                        document.getElementById("centrooperaciones").setAttribute("required", "required");
                                                        document.getElementById("label_centrooperaciones").classList.add("required");
                                                    }

                                                    if (data.datos_fac[0].autorizadopor == "1") {
                                                        document.getElementById("autorizacion").setAttribute("required", "required");
                                                        document.getElementById("label_autorizacion").classList.add("required");
                                                    }

                                                    var select_3 = document.getElementById("enmision");
                                                    select_3.innerHTML = '';

                                                    var defaultOption = document.createElement("option");
                                                    defaultOption.value = "Ninguna"; // Puedes establecer el valor de la opción "Ninguna" según tus necesidades
                                                    defaultOption.text = "Ninguna"; // Texto visible de la opción "Ninguna"
                                                    select_3.appendChild(defaultOption);

                                                    var mision_empresas_3 = data.mision;
                                                    for (var i = 0; i < mision_empresas_3.length; i++) {
                                                        $('#enmision').append($('<option>', {
                                                            value: mision_empresas_3[i].idempresa,
                                                            text: mision_empresas_3[i].empresa
                                                        }));
                                                    }


                                                    // AGREGAR LAS MISIONES A EL SELECT
                                                    // var select_3 = document.getElementById("enmision");
                                                    // select_3.innerHTML = '';

                                                    // // Agrega la opción "Ninguna" al principio
                                                    // var defaultOption = document.createElement("option");
                                                    // defaultOption.value = ""; // Puedes establecer el valor de la opción "Ninguna" según tus necesidades
                                                    // defaultOption.text = "Ninguna"; // Texto visible de la opción "Ninguna"
                                                    // select_3.appendChild(defaultOption);

                                                    // var mision_empresas_3 = data.mision;
                                                    // for (var i = 0; i < mision_empresas_3.length; i++) {
                                                    //     var option = document.createElement("option"); // Crea un elemento option
                                                    //     option.value = mision_empresas_3[i].idempresa; // Establece el valor de la opción
                                                    //     option.text = mision_empresas_3[i].empresa; // Establece el texto visible de la opción
                                                    //     select_3.appendChild(option); // Agrega la opción al select
                                                    // }

                                                    // AUTORIZADO POR
                                                    var autorizado_por = data.autoriza;
                                                    var select = document.getElementById("autorizacion");
                                                    select.innerHTML = '';

                                                    // Agrega la opción "Ninguna" al principio
                                                    var defaultOption = document.createElement("option");
                                                    defaultOption.value = ""; // Puedes establecer el valor de la opción "Ninguna" según tus necesidades
                                                    defaultOption.text = "Ninguna"; // Texto visible de la opción "Ninguna"
                                                    select.appendChild(defaultOption);

                                                    for (var i = 0; i < autorizado_por.length; i++) {
                                                        var option = document.createElement("option"); // Crea un elemento option
                                                        if (autorizado_por[i].nombre !== null) {
                                                            option.value = autorizado_por[i].nombre; // Establece el valor de la opción
                                                            option.text = autorizado_por[i].nombre; // Establece el texto visible de la opción
                                                            select.appendChild(option); // Agrega la opción al select
                                                        }
                                                    }

                                                    // SERVICIOS

                                                    var servicios = data.servicios;
                                                    // Obtén una referencia al elemento select2
                                                    var select2 = document.getElementById("servicios");

                                                    // Limpia el contenido actual del select2
                                                    select2.innerHTML = '';

                                                    // Agrega la opción "Ninguna" al principio
                                                    var defaultOption = document.createElement("option");
                                                    defaultOption.value = ""; // Establece el valor de la opción "Ninguna" según tus necesidades
                                                    defaultOption.text = "Ninguna"; // Texto visible de la opción "Ninguna"
                                                    select2.appendChild(defaultOption);

                                                    // Itera a través del array de servicios y agrega las opciones al select2
                                                    for (var i = 0; i < servicios.length; i++) {
                                                        var servicio = servicios[i];
                                                        var option = document.createElement("option");
                                                        option.value = servicio.idlistaprecio + '/' + servicio.valor_empresa + '/' + servicio.servicio + '/' + servicio.tiposervicio + '/' + servicio.grupo + '/' + servicio.codigo; // Establece el valor de la opción (puedes cambiarlo según tus necesidades)
                                                        option.text = servicio.servicio; // Establece el texto visible de la opción (puedes cambiarlo según tus necesidades)
                                                        select2.appendChild(option); // Agrega la opción al select2
                                                    }

                                                })
                                                .catch(error => {
                                                    // Swal.fire({
                                                    //     text: "ERROR EN CONSULTAR LAS MISIONES",
                                                    //     icon: "danger",
                                                    // });
                                                });
                                            // console.log("El valor seleccionado es: " + selectedValue);
                                        });



                                        if (Array.isArray(data.paciente) && data.paciente.length === 0) {
                                            Swal.fire({
                                                text: "Paciente Nuevo, por favor diligencia todos los datos",
                                                icon: "warning",
                                            });
                                            document.getElementById("primernombre").value = "";
                                            document.getElementById("paciente_nuevo").value = "si";
                                            document.getElementById("segundonombre").value = "";
                                            document.getElementById("primerapellido").value = "";
                                            document.getElementById("segundoapellido").value = "";
                                            document.getElementById("email").value = "";
                                            document.getElementById("direccion").value = "";
                                            document.getElementById("telefono").value = "";
                                            document.getElementById("tipodoc").selectedIndex = 0;
                                            document.getElementById("ciudadorigen").selectedIndex = 0;
                                            document.getElementById("sexo").selectedIndex = 0;
                                        } else {
                                            document.getElementById("paciente_nuevo").value = "no";
                                            document.getElementById("id_paciente").value = data.paciente[0].idpaciente;
                                            // TIPOS DE DOCUMENTO
                                            var valorDeseado = data.paciente[0].tipodoc;
                                            var selectElement = document.getElementById("tipodoc");
                                            for (var i = 0; i < selectElement.options.length; i++) {
                                                if (selectElement.options[i].value === valorDeseado) {
                                                    selectElement.options[i].selected = true;
                                                    break;
                                                }
                                            }

                                            // DATOS DEL PACIENTE BASICOS
                                            document.getElementById("primernombre").value = data.paciente[0].primernombre;
                                            document.getElementById("segundonombre").value = data.paciente[0].segundonombre;
                                            document.getElementById("primerapellido").value = data.paciente[0].primerapellido;
                                            document.getElementById("segundoapellido").value = data.paciente[0].segundoapellido;
                                            document.getElementById("email").value = data.paciente[0].email;
                                            document.getElementById("direccion").value = data.paciente[0].direccion;
                                            document.getElementById("telefono").value = data.paciente[0].telefono;

                                            // sexo
                                            var valorDeseado_1 = data.paciente[0].sexo;
                                            var selectElement = document.getElementById("sexo");
                                            for (var i = 0; i < selectElement.options.length; i++) {
                                                if (selectElement.options[i].value === valorDeseado_1) {
                                                    selectElement.options[i].selected = true;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                })
                                .catch(error => {
                                    // console.error('Error:', error);
                                });

                        } else {

                            Swal.fire({
                                text: "Para generar la Reserva, debes de llenar los campos requeridos!!!",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    }));
                }));

                // Obtiene una referencia al botón
                var submitButton = document.getElementById("kt_modal_add_event_submit");

                // Escucha el evento clic del botón
                submitButton.addEventListener("click", (function(t) {
                    t.preventDefault();
                    var datos = $(p).serializeArray();

                    const origen = datos.find(item => item.name === 'origen')?.value;
                    const fecha_estimada_inicio = datos.find(item => item.name === 'fecha_estimada_inicio')?.value;
                    const hora_estimada_inicio = datos.find(item => item.name === 'hora_estimada_inicio')?.value;
                    const correo_alterno = datos.find(item => item.name === 'correo_alterno')?.value;
                    const tipodoc = datos.find(item => item.name === 'tipodoc')?.value;
                    const primernombre = datos.find(item => item.name === 'primernombre')?.value;
                    const primerapellido = datos.find(item => item.name === 'primerapellido')?.value;
                    const empresa_buscar = datos.find(item => item.name === 'empresa_buscar')?.value;
                    const enmision = datos.find(item => item.name === 'enmision')?.value;
                    const tipocargo = datos.find(item => item.name === 'tipocargo')?.value;
                    const tipo = datos.find(item => item.name === 'tipo')?.value;
                    const cargo = datos.find(item => item.name === 'cargo')?.value;
                    const servicios = datos.find(item => item.name === 'servicios')?.value;

                    if (origen == "" || fecha_estimada_inicio == "" || hora_estimada_inicio == "" || correo_alterno == "" || tipodoc == "" || primernombre == "" || primerapellido == "" || empresa_buscar == "" || enmision == "" || tipocargo == "" || tipo == "" || cargo == "" || servicios == "") {
                        // console.log('-------------- aAAQUI---------', datos);
                        Swal.fire(
                            'Faltan campos!!',
                            'Faltan campos por llenar, verifica los que tienen el * de color rojo, son obligatorios',
                            'error'
                        )
                    } else {

                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: 'Esta acción no se puede deshacer.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Aceptar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {


                                // AGREGAR TODOS LOS DATOS DEL FORMULARIO A DATOSOBJECTO
                                var datosObjeto = {};
                                $.each(datos, function(index, campo) {
                                    // Verificar si el campo es un campo Select2 múltiple
                                    if ($('[name="' + campo.name + '"]').hasClass('js-example-basic-multiple')) {
                                        var valoresSeleccionados = $('[name="' + campo.name + '"]').val();
                                        datosObjeto[campo.name] = valoresSeleccionados;
                                    } else {
                                        datosObjeto[campo.name] = campo.value;
                                    }
                                });

                                Swal.fire({
                                    title: 'Cargando...',
                                    timerProgressBar: true,
                                    onBeforeOpen: () => {
                                        Swal.showLoading();
                                    },
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                });

                                fetch('src/ajax/a_agenda_reservas.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            accion: 'generar_cita',
                                            data: datosObjeto
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        Swal.close();
                                        // console.log(data.resultado);
                                        if (data.resultado == "ok") {
                                            // Swal.fire('¡Cita generada!!', 'La cita se ha generado exitosamente', 'success');
                                            setTimeout((function() {
                                                _.removeAttribute("data-kt-indicator"), Swal.fire({
                                                    text: "!Reserva generada!! La reserva se ha generado exitosamente",
                                                    icon: "success",
                                                    buttonsStyling: !1,
                                                    confirmButtonText: "Ok, got it!",
                                                    customClass: {
                                                        confirmButton: "btn btn-primary"
                                                    }
                                                }).then((function(t) {
                                                    if (t.isConfirmed) {
                                                        // var description = 
                                                        // v.hide(), _.disabled = !1, e.getEventById(x.id).remove();
                                                        let t = !1;
                                                        r.checked && (t = !0), 0 === c.selectedDates.length && (t = !0);
                                                        var l = moment(i.selectedDates[0]).format(),
                                                            s = moment(d.selectedDates[d.selectedDates.length - 1]).format();
                                                        if (!t) {
                                                            const e = moment(i.selectedDates[0]).format("YYYY-MM-DD"),
                                                                t = e;
                                                            l = e + "T" + moment(c.selectedDates[0]).format("HH:mm:ss"), s = t + "T" + moment(u.selectedDates[0]).format("HH:mm:ss")
                                                        }

                                                        v.hide(), e.dismiss;
                                                        document.getElementById('crear_orden').style.display = 'none';
                                                        var tipocargo = $('#tipocargo');
                                                        tipocargo.val([]).trigger('change');
                                                        var servicios = $('#servicios');
                                                        servicios.val([]).trigger('change');

                                                        e.addEvent({
                                                            id: V(),
                                                            title: data.title,
                                                            description: data.description,
                                                            location: data.location,
                                                            start: l,
                                                            end: s,
                                                            allDay: t
                                                        }), e.render(), p.reset();
                                                        // console.log("Antes de abrir la nueva ventana");

                                                        var url = " /dist/index_impresion.php?url_id=orden_sede_detalle_impresion&id=" + data.orden + "&sede=" + data.sede;
                                                        var ventanaNueva = window.open(url, "_blank");

                                                    }
                                                }))
                                            }), 1e3);
                                        } else if (data.resultado == "error_conexion") {
                                            Swal.fire('¡ERROR CONEXION!!', 'La sede ' + data.sede + ' se encuentra sin conexión o con intermitencias, por favor comunicate con sistemas si el error persiste ', 'error');
                                        } else {
                                            Swal.fire('¡ERROR!!', 'Por favor comunicarse con sistemas, ' + data.resultado, 'error');
                                        }
                                    })
                                    .catch(error => {});

                            } else {
                                // El usuario hizo clic en el botón "Cancelar" o cerró la alerta
                                Swal.fire('Cancelado', 'La acción ha sido cancelada.', 'error');
                            }
                        });



                    }
                }));


                w = new bootstrap.Modal(B), g = B.querySelector('[data-kt-calendar="event_name"]'), S = B.querySelector('[data-kt-calendar="all_day"]'), Y = B.querySelector('[data-kt-calendar="event_description"]'), h = B.querySelector('[data-kt-calendar="event_location"]'), T = B.querySelector('[data-kt-calendar="event_start_date"]'), M = B.querySelector('[data-kt-calendar="event_end_date"]'), E = B.querySelector("#kt_modal_view_event_edit"), L = B.querySelector("#kt_modal_view_event_delete"), F = document.getElementById("kt_calendar_app"), O = moment().startOf("day"), I = O.format("YYYY-MM"), R = O.clone().subtract(1, "day").format("YYYY-MM-DD"), G = O.format("YYYY-MM-DD"), K = O.clone().add(1, "day").format("YYYY-MM-DD"), (e = new FullCalendar.Calendar(F, {
                        headerToolbar: {
                            left: "prev,next today",
                            center: "title",
                            right: "dayGridMonth,timeGridWeek,timeGridDay"
                        },
                        initialDate: G,
                        navLinks: !0,
                        selectable: !0,
                        selectMirror: !0,
                        select: function(e) {
                            C(), P(e), N()
                        },
                        eventClick: function(e) {
                            C(), P({
                                id: e.event.id,
                                title: e.event.title,
                                description: e.event.extendedProps.description,
                                location: e.event.extendedProps.location,
                                startStr: e.event.startStr,
                                endStr: e.event.endStr,
                                allDay: e.event.allDay
                            }), A()
                            // console.log("hola");

                        },
                        eventMouseEnter: function(e) {
                            P({
                                id: e.event.id,
                                title: e.event.title,
                                description: e.event.extendedProps.description,
                                location: e.event.extendedProps.location,
                                startStr: e.event.startStr,
                                endStr: e.event.endStr,
                                allDay: e.event.allDay
                            }), q(e.el)
                        },

                        editable: true,
                        dayMaxEvents: true,
                        navLinks: true,
                        events: <?php echo ($disponibilidad_profesional); ?>,
                        datesSet: function() {
                            C()
                        }
                    })).render(), y = FormValidation.formValidation(p, {
                        fields: {
                            calendar_event_name: {
                                validators: {
                                    notEmpty: {
                                        message: "La sede es requerida"
                                    }
                                }
                            },
                            calendar_event_start_date: {
                                validators: {
                                    notEmpty: {
                                        message: "La fecha es requerida"
                                    }
                                }
                            },
                            calendar_event_start_time: {
                                validators: {
                                    notEmpty: {
                                        message: "La hora de inicio es requerida"
                                    }
                                }
                            },
                            calendar_event_end_time: {
                                validators: {
                                    notEmpty: {
                                        message: "La hora de fin es requerida"
                                    }
                                }
                            },
                            calendar_event_description: {
                                validators: {
                                    notEmpty: {
                                        message: "El numero de cedula es requerido"
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: ""
                            })
                        }
                    }), i = flatpickr(r, {
                        enableTime: !1,
                        dateFormat: "Y-m-d"
                    }), d = flatpickr(l, {
                        enableTime: !1,
                        dateFormat: "Y-m-d"
                    }), c = flatpickr(s, {
                        enableTime: !0,
                        noCalendar: !0,
                        dateFormat: "H:i"
                    }), u = flatpickr(m, {
                        enableTime: !0,
                        noCalendar: !0,
                        dateFormat: "H:i"
                    }),
                    H(), D.addEventListener("click", (e => {
                        console.log("291");
                        C(), x = {
                                id: "",
                                eventName: "",
                                eventDescription: "",
                                startDate: new Date,
                                endDate: new Date,
                                allDay: !1
                            },
                            N()
                    })),

                    // ELIMINAR LA CITA
                    L.addEventListener("click", (t => {
                        t.preventDefault();
                        isClickEventAttached = true;
                        Swal.fire({
                            text: "Desea eliminar la reserva?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Si!!",
                            cancelButtonText: "No!!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            if (t.value === true) {
                                // El usuario hizo clic en el botón "confirmar"
                                var datos_agenda = x.eventName;
                                var idagenda = datos_agenda.split('-')[0];
                                var sede = datos_agenda.split('-')[4];
                                fetch('src/ajax/a_agenda_reservas.php', {
                                        method: 'POST', // O 'GET' u otro método según tu necesidad
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            accion: 'eliminar_cita',
                                            idagenda: idagenda,
                                            sede: sede
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        // Manejar la respuesta del servidor aquí
                                        console.log(data);
                                    })
                                    .catch(error => {
                                        // console.error('Error:', error);
                                    });
                                // console.log(x.id);
                                e.getEventById(x.id).remove();
                                e.refetchEvents(); // Esto volverá a cargar los eventos en el calendario
                                w.hide();
                                p.reset();
                            } else if (t.dismiss === Swal.DismissReason.cancel) {
                                // El usuario hizo clic en el botón "cancelar"
                                Swal.fire({
                                    text: "El evento no ha sido elimiado",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        }));
                    })),
                    b.addEventListener("click", (function(e) {
                        e.preventDefault(),
                            Swal.fire({
                                text: "Deseas cancelar la reserva?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Si!!",
                                cancelButtonText: "No!!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-active-light"
                                }
                            }).then((function(e) {
                                e.value ? (p.reset(), v.hide()) : "cancel" === e.dismiss && Swal.fire({
                                    text: "No has cancelado la reserva!!!",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })
                                e.value ? (p.reset(), v.hide()) : "confirm" === e.dismiss,
                                    document.getElementById('crear_orden').style.display = 'none';
                            }))
                    })), k.addEventListener("click", (function(e) {
                        e.preventDefault(), Swal.fire({
                            text: "Deseas cancelar la reserva?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Si!!",
                            cancelButtonText: "No!!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(e) {
                            e.value ? (p.reset(), v.hide()) : "cancel" === e.dismiss && Swal.fire({
                                text: "No has cancelado larReserva!!!",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                            e.value ? (p.reset(), v.hide()) : "confirm" === e.dismiss,
                                document.getElementById('crear_orden').style.display = 'none';

                        }))
                    })), (e => {
                        e.addEventListener("hidden.bs.modal", (e => {
                            y && y.resetForm(!0)
                        }))
                    })(t)
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        // console.log("Initializing KTAppCalendar...");
        KTAppCalendar.init()
    }));
</script>


<!-- Funcionalidad de formulario de Busqueda de paciente  -->
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script language="javascript">
    $("#form_traer_paciente").submit(function(e) {
        e.preventDefault();
        // console.log("hola");
        throw new Error('Este es un mensaje de error y finaliza el programa.');
    });
</script>

<script>
    function mostrar_loader() {
        document.getElementById('cargar_informacion_loader').style.display = 'block';
    }

    function ocultar_loader() {
        document.getElementById('cargar_informacion_loader').style.display = 'none';
    }
</script>