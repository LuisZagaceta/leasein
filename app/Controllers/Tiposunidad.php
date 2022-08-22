<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Tiposunidad extends ResourceController {

    protected $modelName = 'App\Models\Tiposunidad_model';
    protected $format = 'json';

//    List (GET)
    public function index() {
        $pagina = intval($this->request->getGet('pagina') ?? 1);
        $limit = intval($this->request->getGet('limit') ?? 25);
        $offset = ($limit * $pagina) - $limit;

        $total = $this->model->totalRegistros();

        $salida = [
            'total' => intval($total['total']),
            'pagina' => $pagina,
            'limit' => $limit,
            'offset' => $offset,
            'registros' => $this->model->getRegistros($limit, $offset)
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
            'tipo' => $this->request->getPost('tipo'),
        ];

        return $this->respond($this->model->insert($data));
    }

    //Update (PUT)
    public function update($id = NULL) {
        $input = $this->request->getRawInput();
        
        $data = [
            'tipo' => $input['tipo'],
        ];

        return $this->respond($this->model->update($id, $data));
    }

}
