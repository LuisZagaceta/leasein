<?php

namespace App\Models;

use CodeIgniter\Model;

class Asignaciones_model extends Model {

    protected $table = 'asignaciones';
    protected $primaryKey = 'idasignacion';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idcliente', 'codigo', 'idasesor', 'fecha_ini', 'fecha_fin', 'devuelto'];
    //
    protected $useTimestamps = false;
    protected $createdField = '';
    protected $updatedField = '';
    protected $deletedField = '';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getRegistros($buscar = [], $limit = 25, $offset = 0) {
        $stmt = "SELECT ";
        $stmt .= "    a.* ";
        $stmt .= "    , b.*, b1.tipo, b2.marca AS marca_unidad, b3.procesador, b4.marca AS marca_procesador, b3.generacion ";
        $stmt .= "    , c.empresa, c.tamano, c.fecha, c1.* ";
        $stmt .= "    , d.nombre, d.correo, d.celular ";
        $stmt .= "FROM asignaciones AS a ";
        $stmt .= "INNER JOIN unidades_alquiler AS b ON (b.codigo = a.codigo) ";
        $stmt .= "INNER JOIN tipos_unidad AS b1 ON (b1.idtipo = b.idtipo) ";
        $stmt .= "INNER JOIN marcas AS b2 ON (b2.idmarca = b.idmarca) ";
        $stmt .= "INNER JOIN procesadores AS b3 ON (b3.idprocesador = b.idprocesador) ";
        $stmt .= "INNER JOIN marcas AS b4 ON (b4.idmarca = b3.idmarca) ";
        $stmt .= "INNER JOIN clientes AS c ON (c.idcliente = a.idcliente) ";
        $stmt .= "INNER JOIN clientes_sectores AS c1 ON (c1.idsector = c.idsector) ";
        $stmt .= "INNER JOIN asesores AS d ON (d.idasesor = a.idasesor) ";

        if (!empty($buscar['codigo']) || $buscar['cliente'] > 0 || $buscar['asesor'] > 0) {
            $stmt .= "WHERE ";

            $where = [];

            if (!empty($buscar['codigo'])) {
                $where[] = "a.codigo = '" . $buscar['codigo'] . "'";
            }

            if ($buscar['cliente'] > 0) {
                $where[] = "a.idcliente = '" . $buscar['cliente'] . "'";
            }

            if ($buscar['asesor'] > 0) {
                $where[] = "a.idasesor = '" . $buscar['asesor'] . "'";
            }

            $stmt .= implode(' AND ', $where);
        }

        $stmt .= "ORDER BY a.idasignacion DESC ";
        $stmt .= "LIMIT " . $offset . ", " . $limit;

        $query = $this->query($stmt);

        return $query->getResultArray();
    }

    public function totalRegistros($buscar = []) {
        $stmt = "SELECT ";
        $stmt .= "    count(a.idasignacion) AS total ";
        $stmt .= "FROM asignaciones AS a ";
        $stmt .= "INNER JOIN unidades_alquiler AS b ON (b.codigo = a.codigo) ";
        $stmt .= "INNER JOIN tipos_unidad AS b1 ON (b1.idtipo = b.idtipo) ";
        $stmt .= "INNER JOIN marcas AS b2 ON (b2.idmarca = b.idmarca) ";
        $stmt .= "INNER JOIN procesadores AS b3 ON (b3.idprocesador = b.idprocesador) ";
        $stmt .= "INNER JOIN marcas AS b4 ON (b4.idmarca = b3.idmarca) ";
        $stmt .= "INNER JOIN clientes AS c ON (c.idcliente = a.idcliente) ";
        $stmt .= "INNER JOIN clientes_sectores AS c1 ON (c1.idsector = c.idsector) ";
        $stmt .= "INNER JOIN asesores AS d ON (d.idasesor = a.idasesor) ";

        if (!empty($buscar['codigo']) || $buscar['cliente'] > 0 || $buscar['asesor'] > 0) {
            $stmt .= "WHERE ";

            $where = [];

            if (!empty($buscar['codigo'])) {
                $where[] = "a.codigo = '" . $buscar['codigo'] . "'";
            }

            if ($buscar['cliente'] > 0) {
                $where[] = "a.idcliente = '" . $buscar['cliente'] . "'";
            }

            if ($buscar['asesor'] > 0) {
                $where[] = "a.idasesor = '" . $buscar['asesor'] . "'";
            }

            $stmt .= implode(' AND ', $where);
        }


        $query = $this->query($stmt);

        return $query->getRowArray();
    }

}
