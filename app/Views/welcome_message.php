<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    </head>
    <body>
        <div class="container py-5">
            <h1>Asignaciones</h1>
            <!--<button class="btn btn-primary mb-3 cls-add">+ Nueva Asignación</button>-->

            <div id="filtros" class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <!--<label for="iunidad" class="form-label">Unidad</label>-->
                        <select class="form-select" id="iunidad" name="codigo" required>
                            <option value="">Unidades</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <!--<label for="icliente" class="form-label">Cliente</label>-->

                        <select class="form-select" id="icliente" name="cliente" required>
                            <option value="">Cliente</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <!--<label for="iasesor" class="form-label">Asesor</label>-->

                        <select class="form-select" id="iasesor" name="asesor" required>
                            <option value="">Asesor</option>
                        </select>
                    </div>
                </div>
            </div>

            <table id="table-asignaciones" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Procesador</th>
                        <th scope="col">Generacion</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">Asesor</th>
                        <th scope="col">Fecha Ini</th>
                        <th scope="col">Fecha Fin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="9" class="text-center"><strong>...Cargando datos</strong></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="9">
                            <div class="row">
                                <div class="col">
                                    <nav aria-label="Page navigation example">
                                        <ul id="paginador" class="pagination mb-0"></ul>
                                    </nav>
                                </div>
                                <div class="col-auto">
                                    Total registros: <span id="total-registros">0</span>
                                </div>
                            </div>

                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(function () {

                $('#iunidad').select2({
                    'width': '100%',
//                    dropdownParent: $('#modal-add'),
                    ajax: {
                        url: './unidades',
                        dataType: 'json',
                        data: function (params) {
                            var query = {
                                search: params.term,
                                pagina: params.page || 1
                            };

                            return query;
                        },
                        processResults: function (data, params) {
                            let result = {
                                "results": [
                                    {
                                        id: '',
                                        text: 'Unidades'
                                    }
                                ],
                                "pagination": {
                                    "more": (data.limit * data.pagina) < data.total
                                }
                            };

                            if (data.total > 0) {
                                for (var i in data.registros) {
                                    let registro = data.registros[i];

                                    result['results'].push({
                                        id: registro['codigo'],
                                        text: registro['codigo'] + ' - ' + registro['tipo'] + ' ' + registro['marca'] + ' ' + registro['marca_procesador'] + ' ' + registro['procesador'] + ' ' + registro['generacion'] + ' GEN. | ' + registro['ram'] + ' Ghz. | ' + registro['resolucion'] + ' Res. | ' + registro['display'] + '"'
                                    });
                                }
                            }

                            return result;
                        }
                    }
                }).on('change', function () {
                    getAsignaciones({"pagina": 1});
                });

                $('#icliente').on('change', function () {
                    getAsignaciones({"pagina": 1});
                });

                $('#iasesor').on('change', function () {
                    getAsignaciones({"pagina": 1});
                });

                $('#table-asignaciones').on('click', '.page-link', function (ev) {
                    ev.preventDefault();

                    let pagina = this.dataset.pagina;

                    getAsignaciones({"pagina": pagina});
                });

                function getClientes() {
                    $.ajax({
                        url: "./clientes",
                        method: "GET",
                        data: {}
                    }).done(function (response) {
                        let data = [];
                        if (response.total > 0) {
                            for (var i in response.registros) {
                                data.push({
                                    "id": response.registros[i]['idcliente'],
                                    "label": response.registros[i]['empresa']
                                });
                            }

                            llenarSelects('#icliente', 'Clientes', data);
                        }
                    });
                }

                function getAsesores() {
                    $.ajax({
                        url: "./asesores",
                        method: "GET",
                        data: {}
                    }).done(function (response) {
                        let data = [];
                        if (response.total > 0) {
                            for (var i in response.registros) {
                                data.push({
                                    "id": response.registros[i]['idasesor'],
                                    "label": response.registros[i]['nombre']
                                });
                            }

                            llenarSelects('#iasesor', 'Asesores', data);
                        }
                    });
                }

                function llenarSelects(idselect, label, data) {
                    let $select = $(idselect);
                    let options = '<option value="">' + label + '</option>';
//                    options += '<option value="add">+ Registrar Nuevo</option>';

                    $select.empty();
                    for (var i in data) {
                        options += '<option value="' + data[i]['id'] + '">' + data[i]['label'] + '</option>';
                    }

                    $select.append(options);
                }

                function getAsignaciones(params) {
                    let $filtros = $('#filtros').find(':input');
                    let $tabla = $('#table-asignaciones');
                    let $tbody = $tabla.find('tbody');
                    let $paginador = $('#paginador');
                    let $totalRegistros = $('#total-registros');

                    $tbody.empty().append('<tr><td colspan="9" class="text-center"><strong>...Cargando datos</strong></td></tr>');
                    $paginador.empty();

                    let parametros = $filtros.serializeArray();
                    parametros.push({
                        name: 'pagina',
                        value: params.pagina
                    });

                    $.ajax({
                        url: "./asignaciones",
                        method: "GET",
                        data: parametros
                    }).done(function (response) {
                        let registros = [];
                        let paginador = '';
                        let paginas = Math.ceil(response.total / response.limit);

                        if (response.total > 0) {
                            for (var i in response.registros) {
                                let registro = response.registros[i];
                                let fecha_ini = registro['fecha_ini'].split('-').reverse();
                                let fecha_fin = !!registro['fecha_fin'] ? registro['fecha_fin'].split('-').reverse() : [];

                                let template = '<tr>';
                                template += '    <td>' + registro['codigo'] + '</td>';
                                template += '    <td class="text-center">' + registro['tipo'] + '</td>';
                                template += '    <td class="text-center">' + registro['marca_unidad'] + '</td>';
                                template += '    <td class="text-center">' + registro['procesador'] + '</td>';
                                template += '    <td class="text-center">' + registro['generacion'] + '</td>';
                                template += '    <td>' + registro['empresa'] + '</td>';
                                template += '    <td>' + registro['nombre'] + '</td>';
                                template += '    <td>' + fecha_ini.join('/') + '</td>';
                                template += '    <td>' + fecha_fin.join('/') + '</td>';
                                template += '</tr>';

                                registros.push(template);
                            }

                            for (var i = 1; i <= paginas; i++) {
                                let active = (i === parseInt(response.pagina)) ? 'active' : '';
                                paginador += '<li class="page-item ' + active + '"><a class="page-link" href="#" data-pagina="' + i + '">' + i + '</a></li>';
                            }

                        }

                        $tbody.empty().append(registros.join(''));
                        $paginador.empty().append(paginador);

                        $totalRegistros.text(response.total);
                    });
                }

                getClientes();
                getAsesores();
                getAsignaciones({"pagina": 1});
            });
        </script>
    </body>
</html>