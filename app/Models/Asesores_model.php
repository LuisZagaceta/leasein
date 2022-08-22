<?php

namespace App\Models;

use CodeIgniter\Model;

class Asesores_model extends Model {

    protected $table = 'asesores';
    protected $primaryKey = 'idasesor';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nombre', 'correo', 'celular', 'fecha'];
    //
    protected $useTimestamps = false;
    protected $createdField = '';
    protected $updatedField = '';
    protected $deletedField = '';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getRegistros($limit = 25, $offset = 0) {
        $this->limit($limit, $offset);
        $query = $this->get();

        return $query->getResultArray();
    }

    public function totalRegistros() {
        $this->select('count(*) AS total');
        $query = $this->get();

        return $query->getRowArray();
    }

}
