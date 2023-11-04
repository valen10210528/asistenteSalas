<div class="row g-5 g-xl-8">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                    </div>
                </div>
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Filtros
                        </button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-4 text-dark fw-bolder">Opciones de Filtros</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->


                            <form class="form" action="?url_id=gestion_personal" method="POST" id="consultar_personal" name="consultar_personal" enctype="multipart/form-data">
                                <input type="hidden" name="formulario" id="formulario" value="consultar_personal">
                                <div class="scroll-y mh-300px mh-lg-325px">
                                    <div class="px-7 py-5">
                                        <div class="mb-10">
                                            <label class="form-label fs-5 fw-bold mb-3">Nombre:</label>
                                            <input id="nombre" name="nombre" type="text" class="form-control form-control-solid" />
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <input type="submit" name="enviar" class="btn btn-primary" value="Filtrar">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--begin::Action-->
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_api_key">
                            Crear Sede
                        </a>
                        <!--end::Action-->
                        <!--end::Crear-->
                    </div>

                    <!--begin::Group actions-->
                    <!--end::Group actions-->
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="card-scroll">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-185px"></th>
                                <th class="min-w-185px">Usuario</th>
                                <th class="min-w-185px">Contraseña</th>
                                <th class="min-w-125px">Nombre Completo</th>
                                <th class="min-w-185px">Correo</th>
                                <th class="min-w-125px">Telefono</th>
                                <th class="min-w-125px">Dirección</th>
                                <th class="min-w-125px">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                            <?php
                            if ($consulta != "") {
                                while ($fila = $consulta->fetch()) {
                            ?>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <td class="min-w-185px"></td>
                                        <td class="min-w-185px"><a href="?url_id=usuario&id=<?= $fila['id']  ?>" target="_blank" class="btn btn-primary"><?= $fila['usuario']  ?></a></td>
                                        <td class="min-w-185px"><?= $fila['contraseña']  ?></td>
                                        <td class="min-w-125px"><?= $fila['nombre']  ?></td>
                                        <td class="min-w-185px"><?= $fila['correo']  ?></td>
                                        <td class="min-w-125px"><?= $fila['telefono']  ?></td>
                                        <td class="min-w-125px"><?= $fila['direccion']  ?></td>
                                        <td class="min-w-125px">
                                            <?php
                                            if ($_SESSION['administrador'] == 1) {
                                                # code...
                                                if ($fila['estado'] == "activo") {
                                            ?>
                                                    <a href="?url_id=gestion_personal&accion=inactivo&id_accion=<?php echo $fila['id'] ?>">
                                                        <button type="button" class="btn btn-light-success me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                                                            ACTIVO
                                                        </button>
                                                    </a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="?url_id=gestion_personal&accion=activo&id_accion=<?php echo $fila['id'] ?>">
                                                        <button type="button" class="btn btn-light-danger me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                                                            INACTIVO
                                                        </button>
                                                    </a>
                                            <?php
                                                }
                                            } else {
                                                echo $fila['estado'];
                                            }
                                            ?>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_modal_create_api_key" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_create_api_key_header">
                <h2>Crear sede</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <form action="?url_id=gestion_sedes" method="post" id="crear_sede" name="crear_sede">
                <input type="hidden" id="formulario" name="formulario" value="crear_sede">
                <div class="m-5 p-3">
                    <label class="required fs-5 fw-bold mb-2"> Nombre sede</label>
                    <input required type="text" class="form-control" id="nombre_sede" name="nombre_sede">
                </div>
                <div class="m-5 p-3">
                    <label class="required fs-5 fw-bold mb-2"> Dirección sede</label>
                    <input required type="text" class="form-control" id="direccion_sede" name="direccion_sede">
                </div>
                <div class="m-5 p-3">
                    <input type="submit" value="Crear sede" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>