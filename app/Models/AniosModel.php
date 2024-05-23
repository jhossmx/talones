<?php

namespace App\Models;

use CodeIgniter\Model;

class AniosModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'c_anios';
    protected $primaryKey = 'cn_id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDelete = false;
    protected $protectFields = true;
    protected $allowedFields = ['da_nombre', 'da_status'];

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

    public function getAnios($slug = false)
    {
        if ($slug === false) {
            return $this->orderBy('cn_id','desc')
                ->findAll();
        }

        return $this->asArray()
            ->where(['cn_id' => $slug])
            ->orderBy('cn_id','desc')
            ->first();
    }

    public function getAnioCompleto($idAnio){
        $anio = 0;
        $sql = "Select ca.da_nombre as anio
                From c_anios ca
                Where ca.cn_id=".$idAnio;
        $query = $this->db->query($sql);
        foreach ($query->getResultArray() as $row) {
            $anio = $row['anio'];
        }
        return (string) $anio;

    }
}