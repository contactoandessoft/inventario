<?php

namespace App\Models;

use CodeIgniter\Model;

class usuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user','nombre_usuario','clave','correo','vigencia','fecha_audita'];

    protected bool $allowEmptyInserts = false;
    
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function validateUser($user, $clave){
        $user = $this->where(['user' => $user, 'vigencia' => 1])->first();
        if($user && password_verify($clave,$user['clave'])){
            return $user;
        }

        return null;
    }


    public function obtenerUsuariosActivos()
    {
        return $this->where('vigencia', 1)->findAll();
    }

}
