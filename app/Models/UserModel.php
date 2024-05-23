<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    //https: //codeigniter4.github.io/CodeIgniter4/models/entities.html
    //https://stackoverflow.com/questions/62353435/forge-migrate-codeigniter-4-foreign-key-error
    protected $table = 's_usuarios';
    protected $primaryKey = 'cn_id';
    protected $allowedFields = [
        'da_rfc'
        , 'da_curp'
        , 'da_clave'
        , 'da_apel1'
        , 'da_apel2'
        , 'da_nombre'
        , 'fn_tipousuario'
        , 'da_status',
    ];

    public function registrar($infoUser = [])
    {
        $id = 0;
        $this->db->transBegin();
        $this->db->table('s_usuarios')->insert($infoUser);
        $id = $this->db->insertID();
        if ($this->db->transStatus() === true) {
            $this->db->transCommit();
        } else {
            $this->db->transRollback();
        }
        return $id;
    }

}