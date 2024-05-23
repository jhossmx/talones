<?php

namespace App\Models;

use CodeIgniter\Model;

class PagosModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'm_pagos';
    protected $primaryKey = 'cn_id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDelete = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'fn_usuario', 'fn_anio', 'fn_quincena', 'df_fecha_pago',
        'df_fecha_inicio_pago', 'df_fecha_fin_pago', 'dn_dias_pago', 'dn_subtotal', 'dn_decucciones',
        'dn_total', 'da_uuid', 'da_status',
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

    public function getIdAnio($anio = "0")
    {
        $idAnio = 0;
        $sql = "Select ca.cn_id
                From c_anios ca
                Where ca.da_nombre ='" . $anio . "'";
        $query = $this->db->query($sql);
        foreach ($query->getResultArray() as $row) {
            $idAnio = $row['cn_id'];
        }
        return (int) $idAnio;

    }

    public function getMasterPagos($idPago = false)
    {
        if ($idPago === false) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['cn_id' => $idPago])
            ->first();

    }

    public function existePagosEnAnio($anio = 0, $IdUser = 0){

        $cant = 0;
        $sql = "Select count(*) as cant
                From m_pagos mp
                Where mp.fn_anio=" . $anio . " and mp.fn_usuario=" . $IdUser;
        $query = $this->db->query($sql);
        foreach ($query->getResultArray() as $row) {
            $cant = $row['cant'];
        }
        return (int) $cant;
    }

    public function deletePagoAnio($anio = 0, $IdUser = 0)
    {

        $this->db->transBegin();
        $sql = "Delete from d_pagos Where fn_anio=" . $anio . " and fn_usuario=" . $IdUser;
        $this->db->query($sql);

        $sql = "Delete from m_pagos Where fn_anio=" . $anio . " and fn_usuario=" . $IdUser;
        $this->db->query($sql);

        if ($this->db->transStatus() === true) {
            $this->db->transCommit();
            return true; //echo "Commit";
        } else {
            $this->db->transRollback();
            return false; //echo "Rollback";
        }

    }
    
    public function existePago($anio = 0, $quincena = 0, $IdUser = 0)
    {

        $cant = 0;
        $sql = "Select count(*) as cant
                From m_pagos mp
                Where mp.fn_anio=" . $anio . " and mp.fn_quincena=" . $quincena . " and mp.fn_usuario=" . $IdUser;
        $query = $this->db->query($sql);
        foreach ($query->getResultArray() as $row) {
            $cant = $row['cant'];
        }
        return (int) $cant;
    }

    public function deletePago($anio = 0, $quincena = 0, $IdUser = 0)
    {

        $this->db->transBegin();
        $sql = "Delete from d_pagos Where fn_anio=" . $anio . " and fn_quincena=" . $quincena . " and fn_usuario=" . $IdUser;
        $this->db->query($sql);

        $sql = "Delete from m_pagos Where fn_anio=" . $anio . " and fn_quincena=" . $quincena . " and fn_usuario=" . $IdUser;
        $this->db->query($sql);

        if ($this->db->transStatus() === true) {
            $this->db->transCommit();
            return true; //echo "Commit";
        } else {
            $this->db->transRollback();
            return false; //echo "Rollback";
        }

    }

    public function insertPagosDb($file)
    {
        $pagos = $file[0];
        $percepciones = $file[1];
        $deducciones = $file[2];

        $this->db->transBegin();

        //insert tabla maestra
        $this->db->table('m_pagos')->insert($pagos);
        $id = $this->db->insertID();
        //$this->modelPagos->insert($pagos);
        //$id = $modelPagos->insertID;

        //insert tabla detalle
        if ($id > 0 && count($percepciones) > 0) {
            foreach ($percepciones as $percepcion) {
                $percepcion['fn_pago'] = $id;
                //$this->modelDetallePagos->insert($percepcion);
                $this->db->table('d_pagos')->insert($percepcion);
            }
        }

        //inseret tabla detalle
        if ($id > 0 && count($deducciones) > 0) {
            foreach ($deducciones as $deduccion) {
                $deduccion['fn_pago'] = $id;
                $this->db->table('d_pagos')->insert($deduccion);
                //$this->modelDetallePagos->insert($deduccion);
            }
        }

        if ($this->db->transStatus() === true) {
            $this->db->transCommit();
            return true; //echo "Commit";

        } else {
            $this->db->transRollback();
            return false; //echo "Rollback";

        }
    }

    public function deletePagosDb($idAnio = 0, $idUser=0)
    {
        $resp = false;
        $this->db->transBegin();

        $this->db->table("d_pagos")
            ->where('fn_anio', $idAnio)
            ->where('fn_usuario', $idUser)
            ->delete();

        $this->db->table("m_pagos")
            ->where('fn_anio', $idAnio)
            ->where('fn_usuario', $idUser)
            ->delete();

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $resp = false;
        } else {
            $this->db->transCommit();
            $resp = true;
        }
        return $resp;
    }

    public function getDatos($anio = 0, $quincena = 0, $tipoNomina = 1, $iduser = 0)
    {
        $datos = [];
        $sql = "Select ca.da_nombre as anio, cq.da_nombre as quincena, dp.da_plaza as plaza, n.da_nombre AS nomina, 
                    ctp.da_nombre as tipo, dp.da_clave as concepto, dp.da_descripcion as descripcion,
                    (dp.dn_importe_gravado + dp.dn_importe_exento) as importe
                From d_pagos dp
                    inner join c_anios ca on(dp.fn_anio=ca.cn_id)
                    inner join c_quincenas cq on (dp.fn_quincena = cq.cn_id)
                    inner join c_tipo_percepcion ctp on (dp.fn_tipoPercepcion = ctp.cn_id)
                    INNER JOIN c_tiponomina n ON (dp.fn_nomina = n.cn_id)
                WHERE fn_anio = ? AND fn_quincena = ? AND dp.fn_nomina = ? AND fn_usuario = ? 
                    and dp.da_clave<>'ISR_P' and dp.da_clave<>'ISR_D' and (dp.dn_importe_gravado + dp.dn_importe_exento) > 0
                Order by  dp.da_plaza, dp.fn_tipoPercepcion, dp.da_clave ";
        $query = $this->db->query($sql, [$anio, $quincena, $tipoNomina, $iduser]);
        foreach ($query->getResult() as $row) {
            $datos[] = $row;
        }
        return $datos;

        //dd($query->getResultArray());

        //$builder = $this->db->table('D_PAGOS');
        //$builder->where('fn_anio', $anio);
        //$builder->where('fn_quincena', $quincena);
        //$builder->where('fn_usuario', $iduser);
        //$query = $builder->get();
        //return $query;
        //return $query->getResult();
    }

    public function getTotalespagos($anio = 0, $quincena = 0, $tipoNomina = 1, $iduser = 0)
    {
        $datos = [];
        /*$sql = "Select SUM(mp.dn_subtotal) as subtotal, SUM(mp.dn_decucciones) as deducciones, SUM(mp.dn_total)  as total
        From pagos.m_pagos mp
        Where mp.fn_anio  = ? and mp.fn_quincena = ? and mp.fn_usuario = ?";*/

        $sql = "Select p.percepcion as subtotal, d.descuentos as deducciones, (p.percepcion-d.descuentos) as total
  	            From m_pagos mp
 	                inner join (
		                Select dp.fn_anio, dp.fn_quincena, dp.fn_nomina, dp.fn_usuario, sum(dp.dn_importe_gravado+dn_importe_exento) as percepcion
		                From d_pagos dp
		                Where dp.fn_anio =" . $anio . "  and dp.fn_quincena =" . $quincena . " and dp.fn_nomina= " . $tipoNomina . " and dp.fn_usuario =" . $iduser . " and dp.fn_tipoPercepcion =1 and dp.da_clave <> 'ISR_P') p
		            on (mp.fn_anio = p.fn_anio and mp.fn_quincena =p.fn_quincena and mp.fn_nomina= p.fn_nomina and mp.fn_usuario=p.fn_usuario)
	                inner join (
		                Select dp.fn_anio, dp.fn_quincena, dp.fn_nomina, dp.fn_usuario, sum(dp.dn_importe_gravado) as descuentos
		                From d_pagos dp
		                Where dp.fn_anio =" . $anio . " and dp.fn_quincena =" . $quincena . " and dp.fn_nomina= " . $tipoNomina ." and dp.fn_usuario =" . $iduser . " and dp.fn_tipoPercepcion =2 and dp.da_clave <> 'ISR_D') d
		            on (mp.fn_anio = d.fn_anio and mp.fn_quincena =d.fn_quincena and mp.fn_nomina= d.fn_nomina and mp.fn_usuario=d.fn_usuario) ";
        //echo $sql; exit;            
        $query = $this->db->query($sql);
        $cant = 0;
        foreach ($query->getResult() as $row) {
            if ($cant == 0) {
                $datos[] = $row;
                break;
            }
        }
        return $datos;

    }

}