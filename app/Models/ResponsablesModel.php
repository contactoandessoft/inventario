<?php

namespace App\Models;

use CodeIgniter\Model;

class ResponsablesModel extends Model
{
    protected $table            = 'responsables';
    protected $primaryKey       = 'id_responsable';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_responsable','vigencia','id_usuario','fecha_audita'];

    protected bool $allowEmptyInserts = false;


    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    //Vista ResponsableForm
    //Método para obtener solo los responsables activos
    public function obtenerResponsablesActivos()
    {
        return $this->where('vigencia', 1)->findAll();
    }

    //Método para registrar un nuevo responsable
    public function registrarResponsable($data)
    {
        return $this->insert($data); 
    }


    // Método para obtener una Responsable por nombre
    public function obtenerResponsablePorNombre($nombre_responsable)
    {
        return $this->where('nombre_responsable', $nombre_responsable)->first(); 
    }



    //Vista Responsable
    // Función para obtener todos los responsables con el nombre de usuario
    public function obtenerResponsablesConUsuario()
    {
        return $this->select('responsables.*, usuarios.nombre_usuario')
                    ->join('usuarios', 'usuarios.id_usuario = responsables.id_usuario', 'left')
                    ->findAll();
    }

    // Función para verificar si un responsable está en uso
    public function responsableEnUso($id_responsable)
    {
        $formularioModel = new FormularioModel();
        return $formularioModel->where('id_responsable', $id_responsable)->first();
    }


    //Vista EditarResponsable
    //Metodo para obtener el Responsable 
    public function obtenerPorId($id_responsable)
    {
        return $this->find($id_responsable);
    }

    // Método para actualizar un responsable
    public function actualizarResponsablee($id_responsable, $data)
    {
        return $this->update($id_responsable, $data);
    }

    //Metodo para Verificar que la fecha no sea mayor a la actual
    public function validarFechaAudita($fecha_audita)
    {
        $currentDate = date('Y-m-d');
        return strtotime($fecha_audita) <= strtotime($currentDate);
    }
    
    

    
}
