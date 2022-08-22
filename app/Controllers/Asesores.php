<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Asesores extends ResourceController {

    protected $modelName = 'App\Models\Asesores_model';
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
            'nombre' => $this->request->getPost('nombre'),
            'correo' => $this->request->getPost('correo'),
            'celular' => $this->request->getPost('celular'),
            'fecha' => date('Y-m-d H:i:s'),
        ];

        return $this->respond($this->model->insert($data)); //devuelve el ultimo id insertado
//        return $this->respond($this->model->save($data));//devuelve true o false
    }

    //Update (PUT)
    public function update($id = NULL) {
        $input = $this->request->getRawInput();
        
        $data = [
            'nombre' => $input['nombre'],
            'correo' => $input['correo'],
            'celular' => $input['celular'],
            'fecha' => date('Y-m-d H:i:s'),
        ];

        return $this->respond($this->model->update($id, $data)); //devuelve true o false
//        return $this->respond($this->model->save($data));//devuelve true o false
    }

}
