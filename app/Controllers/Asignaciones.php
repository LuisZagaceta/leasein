<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Asignaciones extends ResourceController {

    protected $modelName = 'App\Models\Asignaciones_model';
    protected $format = 'json';

//    List (GET)
    public function index() {
        $buscar = [
            'codigo' => $this->request->getGet('codigo') ?? NULL,
            'cliente' => intval($this->request->getGet('cliente') ?? 0),
            'asesor' => intval($this->request->getGet('asesor') ?? 0)
        ];

        $pagina = intval($this->request->getGet('pagina') ?? 1);
        $limit = intval($this->request->getGet('limit') ?? 25);
        $offset = ($limit * $pagina) - $limit;

        $total = $this->model->totalRegistros($buscar);

        $salida = [
            'total' => intval($total['total']),
            'pagina' => $pagina,
            'limit' => $limit,
            'offset' => $offset,
            'registros' => $this->model->getRegistros($buscar, $limit, $offset)
        ];

        return $this->respond($salida);
    }

    //Show (GET)
    public function show($id = NULL) {
        return $this->respond($this->model->find($id));
    }

    //Edit (GET)
    public function edit($id = NULL) {
        return $this->respond($this->model->find($id));
    }

    //Create (POST)
    public function create() {
        $data = [
            'idcliente' => $this->request->getPost('idcliente'),
            'codigo' => $this->request->getPost('codigo'),
            'idasesor' => $this->request->getPost('idasesor'),
            'fecha_ini' => $this->request->getPost('fecha_ini'),
//            'fecha_fin' => $this->request->getPost('celular'),
            'devuelto' => $this->request->getPost('devuelto'),
        ];

        return $this->respond($this->model->insert($data));
    }

    //Update (PUT)
    public function update($id = NULL) {
        $input = $this->request->getRawInput();

        $data = [
            'idcliente' => $input['idcliente'],
            'codigo' => $input['codigo'],
            'idasesor' => $input['idasesor'],
            'fecha_ini' => $input['fecha_ini'],
            'fecha_fin' => $input['fecha_fin'],
            'devuelto' => $input['devuelto'],
        ];

        return $this->respond($this->model->update($id, $data));
    }

}
