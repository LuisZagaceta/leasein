<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Unidades extends ResourceController {

    protected $modelName = 'App\Models\Unidades_model';
    protected $format = 'json';

//    List (GET)
    public function index() {
        $search = $this->request->getGet('search') ?? NULL;

        if (isset($search) && !empty($search)) {
            $search = explode(' ', trim($search));
        }

        $pagina = intval($this->request->getGet('pagina') ?? 1);
        $limit = intval($this->request->getGet('limit') ?? 25);
        $offset = ($limit * $pagina) - $limit;

        $total = $this->model->totalRegistros($search);

        $salida = [
            'total' => intval($total['total'] ?? 0),
            'pagina' => $pagina,
            'limit' => $limit,
            'offset' => $offset,
            'registros' => $this->model->getRegistros($search, $limit, $offset)
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
            'idtipo' => $this->request->getPost('idtipo'),
            'idmarca' => $this->request->getPost('idmarca'),
            'idprocesador' => $this->request->getPost('idprocesador'),
            'velocidad' => $this->request->getPost('velocidad'),
            'ram' => $this->request->getPost('ram'),
            'display' => $this->request->getPost('display'),
            'resolucion' => $this->request->getPost('resolucion'),
            'fecha' => date('Y-m-d H:i:s'),
        ];

        return $this->respond($this->model->insert($data));
    }

    //Update (PUT)
    public function update($id = NULL) {
        $input = $this->request->getRawInput();

        $data = [
            'idtipo' => $input['idtipo'],
            'idmarca' => $input['idmarca'],
            'idprocesador' => $input['idprocesador'],
            'velocidad' => $input['velocidad'],
            'ram' => $input['ram'],
            'display' => $input['display'],
            'resolucion' => $input['resolucion'],
            'fecha' => date('Y-m-d H:i:s'),
        ];

        return $this->respond($this->model->update($id, $data));
    }

}
