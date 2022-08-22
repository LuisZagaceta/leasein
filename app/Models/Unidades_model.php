<?php

namespace App\Models;

use CodeIgniter\Model;

class Unidades_model extends Model {

    protected $table = 'unidades_alquiler';
    protected $primaryKey = 'codigo';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['idtipo', 'idmarca', 'idprocesador', 'velocidad', 'ram', 'display', 'resolucion', 'fecha'];
    //
    protected $useTimestamps = false;
    protected $createdField = '';
    protected $updatedField = '';
    protected $deletedField = '';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getRegistros($search = [], $limit = 25, $offset = 0) {
        $stmt = "SELECT ";
        $stmt .= "    a.* ";
        $stmt .= "    , b.tipo ";
        $stmt .= "    , c.marca ";
        $stmt .= "    , d.procesador, d.generacion ";
        $stmt .= "    , d1.marca AS marca_procesador ";
        $stmt .= "    , CONCAT(a.codigo, '|', b.tipo, '|', c.marca, '|', d.procesador, '|', a.velocidad, '|', a.ram, '|', a.display, '|', a.resolucion, '|', d.generacion,'|', d1.marca) AS busquedad ";
        $stmt .= "FROM unidades_alquiler AS a ";
        $stmt .= "INNER JOIN tipos_unidad AS b ON (b.idtipo = a.idtipo) ";
        $stmt .= "INNER JOIN marcas AS c ON (c.idmarca = a.idmarca) ";
        $stmt .= "INNER JOIN procesadores AS d ON (d.idprocesador = a.idprocesador) ";
        $stmt .= "INNER JOIN marcas AS d1 ON (d1.idmarca = d.idmarca) ";

        if (isset($search) && !empty($search)) {
            $stmt .= "HAVING busquedad LIKE '%" . implode('%\' AND busquedad LIKE \'%', $search) . "%' ";
        }

        $stmt .= "ORDER BY a.codigo DESC ";
        $stmt .= "LIMIT " . $offset . ", " . $limit;

        $query = $this->query($stmt);

        return $query->getResultArray();
    }

    public function totalRegistros($search = []) {
        $stmt = "SELECT ";
//        $stmt .= "    count(a.codigo) AS total ";
        $stmt .= "    CONCAT(a.codigo, '|', b.tipo, '|', c.marca, '|', d.procesador, '|', a.velocidad, '|', a.ram, '|', a.display, '|', a.resolucion, '|', d.generacion,'|', d1.marca) AS busquedad ";
        $stmt .= "FROM unidades_alquiler AS a ";
        $stmt .= "INNER JOIN tipos_unidad AS b ON (b.idtipo = a.idtipo) ";
        $stmt .= "INNER JOIN marcas AS c ON (c.idmarca = a.idmarca) ";
        $stmt .= "INNER JOIN procesadores AS d ON (d.idprocesador = a.idprocesador) ";
        $stmt .= "INNER JOIN marcas AS d1 ON (d1.idmarca = d.idmarca) ";

        if (isset($search) && !empty($search)) {
            $stmt .= "HAVING busquedad LIKE '%" . implode('%\' AND busquedad LIKE \'%', $search) . "%' ";
        }

        $query = $this->query($stmt);

        $results = $query->getResultArray();

        return ["total" => count($results)];
    }

}
