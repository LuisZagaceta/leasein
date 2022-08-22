<?php

namespace App\Models;

use CodeIgniter\Model;

class Clientes_model extends Model {

    protected $table = 'clientes';
    protected $primaryKey = 'idcliente';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idsector', 'empresa', 'tamano', 'fecha'];
    //
    protected $useTimestamps = false;
    protected $createdField = '';
    protected $updatedField = '';
    protected $deletedField = '';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getRegistros($limit = 25, $offset = 0) {
        $stmt = "SELECT * ";
        $stmt .= "FROM clientes AS a ";
        $stmt .= "INNER JOIN clientes_sectores AS b ON (b.idsector = a.idsector) ";
        $stmt .= "ORDER BY a.idcliente ";
        $stmt .= "LIMIT " . $offset . ", " . $limit;

        $query = $this->query($stmt);

        return $query->getResultArray();
    }

    public function totalRegistros() {
        $stmt = "SELECT count(*) AS total ";
        $stmt .= "FROM clientes AS a ";
        $stmt .= "INNER JOIN clientes_sectores AS b ON (b.idsector = a.idsector) ";
        $stmt .= "ORDER BY a.idcliente ";

        $query = $this->query($stmt);

        return $query->getRowArray();
    }

}
