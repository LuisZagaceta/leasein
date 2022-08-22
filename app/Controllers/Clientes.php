<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Clientes extends ResourceController {

    protected $modelName = 'App\Models\Clientes_model';
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
            'idsector' => $this->request->getPost('idsector'),
            'empresa' => $this->request->getPost('empresa'),
            'tamano' => $this->request->getPost('tamano'),
            'fecha' => date('Y-m-d H:i:s'),
        ];

        return $this->respond($this->model->insert($data));
    }

    //Update (PUT)
    public function update($id = NULL) {
        $input = $this->request->getRawInput();
        
        $data = [
            'idsector' => $input['idsector'],
            'empresa' => $input['empresa'],
            'tamano' => $input['tamano'],
            'fecha' => date('Y-m-d H:i:s'),
        ];

        return $this->respond($this->model->update($id, $data));
    }

}
