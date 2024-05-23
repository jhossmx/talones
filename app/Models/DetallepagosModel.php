<?php

namespace App\Models;

use CodeIgniter\Model;

class DetallepagosModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'd_pagos';
    protected $primaryKey = 'cn_id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDelete = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'fn_pago', 'fn_usuario', 'fn_anio', 'fn_quincena', 'fn_tipoConcepto', 'da_clave', 'da_descripcion',
        'dn_importe_gravado', 'dn_importe_exento', 'da_status',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getDatosExcel($anio="3", $idUsuario="0")
    {
        $datos = [];
        $sql = "Select ca.da_nombre as anio, cq.da_nombre as quincena, tn.da_nombre AS nomina, ctp.da_nombre as tipoperocepcion,
                    dp.da_clave as concepto, dp.da_descripcion as descropcion, dp.dn_importe_gravado + dp.dn_importe_exento as importe
                From d_pagos dp
                    inner join c_tipo_percepcion ctp on (dp.fn_tipoPercepcion = ctp.cn_id)
                    inner join c_anios ca on (dp.fn_anio = ca.cn_id)
                    inner join c_quincenas cq on (dp.fn_quincena=cq.cn_id)
                    INNER JOIN c_tiponomina tn ON (dp.fn_nomina = tn.cn_id)
                Where dp.fn_anio = ". $anio ." and fn_usuario = " . $idUsuario . " and dp.da_clave <>'ISR_P' and dp.da_clave <>'ISR_D'
                Order by dp.fn_anio, dp.fn_quincena, dp.fn_nomina, dp.fn_tipoPercepcion , dp.da_clave ";
        $query = $this->db->query($sql);
        foreach ($query->getResult() as $row) {
            $datos[] = $row;
        }
        return $datos;
    }

    public function getPagosAnioQuincena($anio=0, $quin=0, $tipo=0, $idUser=0)
    {
        $datos = [];
        $sql = "Select ca.da_nombre as anio, cq.da_nombre as quincena, dp.da_plaza as plaza, tn.da_nombre AS nomina, ctp.da_nombre as tipoperocepcion,
                    dp.da_clave as concepto, dp.da_descripcion as descropcion, dp.dn_importe_gravado + dp.dn_importe_exento as importe
                From d_pagos dp
                    inner join c_tipo_percepcion ctp on (dp.fn_tipoPercepcion = ctp.cn_id)
                    inner join c_anios ca on (dp.fn_anio = ca.cn_id)
                    inner join c_quincenas cq on (dp.fn_quincena=cq.cn_id)
                    INNER JOIN c_tiponomina tn ON (dp.fn_nomina = tn.cn_id)
                Where dp.fn_anio = ".$anio." and dp.fn_quincena = ".$quin." and dp.fn_tipoPercepcion =".$tipo." and dp.fn_usuario = ".$idUser." and dp.da_clave <>'ISR_P' and dp.da_clave <>'ISR_D' 
                and (dp.dn_importe_gravado + dp.dn_importe_exento) > 0
                Group by ca.da_nombre, cq.da_nombre, tn.da_nombre, ctp.da_nombre, dp.da_clave, dp.da_descripcion
                Order by dp.fn_anio, dp.fn_quincena, dp.da_plaza, dp.fn_nomina, dp.fn_tipoPercepcion , dp.da_clave ";
                //echo $sql;exit;
        $query = $this->db->query($sql);
        foreach ($query->getResult() as $row) {
            $datos[] = $row;
        }
        return $datos;
    }

}