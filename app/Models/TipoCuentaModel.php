<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoCuentaModel extends Model
{
    protected $table            = 'tipocuenta';
    protected $primaryKey       = 'id_cuenta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['num_cuenta','descripcion','vigencia','fecha_audita','id_usuario'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


}
