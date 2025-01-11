<?php

namespace App\Models;

use CodeIgniter\Model;

class FormularioModel extends Model
{
    protected $table = 'formulario';
    protected $primaryKey = 'id_formulario';
    protected $allowedFields = [
        'numero_inventario', 'descripcion', 'id_marcas', 'modelo', 'ano_fabricacion',
        'valor_adquisicion', 'id_responsable', 'estado', 'numero_serie', 'vida_util',
        'id_tipo_equipo', 'fecha_alta', 'seccion', 'dependencia', 'comentarios'
    ];

    //Vista Home
    // Función para mostrar la tabla en el Home
    public function getEquipos()
    {
        return $this->select('formulario.*, marcas.nombre_marca, responsables.nombre_responsable')
                    ->join('marcas', 'marcas.id_marcas = formulario.id_marcas', 'left')
                    ->join('responsables', 'responsables.id_responsable = formulario.id_responsable', 'left')
                    ->findAll();
    }

    //Vista Formulario
    public function getMarcas()
    {
        return $this->db->table('marcas')
                    ->where('vigencia', 1)  
                    ->get()
                    ->getResultArray();
    }

    public function getResponsables()
    {
        return $this->db->table('responsables')
                    ->where('vigencia', 1)  
                    ->get()
                    ->getResultArray();
    }

    public function getTipoEquipo()
    {
        return $this->db->table('tipo_equipo')->get()->getResultArray();
    }

    //Vista Formulario
    // Método para obtener un equipo por su número de inventario 
    public function obtenerEquipoPorInventario($numero_inventario)
    {
        return $this->where('numero_inventario', $numero_inventario)->first();
    }

    //Vista EditarForm
    // Método para actualizar un equipo
    public function actualizarEquipo($id_formulario, $data)
    {
        return $this->update($id_formulario, $data);
    }

    public function validarFechaAlta($fecha_alta)
{
    $currentDate = date('Y-m-d');
    return strtotime($fecha_alta) <= strtotime($currentDate);
}


}


