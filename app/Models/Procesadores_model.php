<?php

namespace App\Models;

use CodeIgniter\Model;

class Procesadores_model extends Model {

    protected $table = 'procesadores';
    protected $primaryKey = 'idprocesador';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idmarca', 'procesador', 'generacion'];
    //
    protected $useTimestamps = false;
    protected $createdField = '';
    protected $updatedField = '';
    protected $deletedField = '';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getRegistros($limit = 25, $offset = 0) {
        $stmt = "SELECT a.*, b.marca ";
        $stmt .= "FROM procesadores AS a ";
        $stmt .= "INNER JOIN marcas AS b ON (b.idmarca = a.idmarca) ";
        $stmt .= "ORDER BY a.idprocesador DESC ";
        $stmt .= "LIMIT " . $offset . ", " . $limit;

        $query = $this->query($stmt);

        return $query->getResultArray();
    }

    public function totalRegistros() {
        $stmt = "SELECT ";
        $stmt .= "    count(a.idprocesador) AS total ";
        $stmt .= "FROM procesadores AS a ";
        $stmt .= "INNER JOIN marcas AS b ON (b.idmarca = a.idmarca) ";
        $stmt .= "ORDER BY a.idprocesador DESC ";

        $query = $this->query($stmt);

        return $query->getRowArray();
    }

}
