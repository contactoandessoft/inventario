<?php

namespace App\Models;

use CodeIgniter\Model;

class MarcasModel extends Model
{
    protected $table = 'marcas';
    protected $primaryKey = 'id_marcas';
    protected $allowedFields = [
        'nombre_marca', 'vigencia', 'fecha_audita', 'id_usuario',
    ];


    //Vista MarcasForm
    // Método para registrar una nueva marca
    public function registrarMarca($data)
    {
        if ($this->where('nombre_marca', $data['nombre_marca'])->first()) {
            return false; 
        }

        return $this->insert($data);
    }

    // Método para obtener una marca por nombre
    public function obtenerMarcaPorNombre($nombre_marca)
    {
        return $this->where('nombre_marca', $nombre_marca)->first();
    }


    //Vista Marcas
    // Método para eliminar una marca
    public function eliminarMarca($id)
    {
        $formularioModel = new FormularioModel();
        $formulario = $formularioModel->where('id_marcas', $id)->first();

        if ($formulario) {
            return 'No se puede eliminar la marca, ya está asociada a un formulario.';
        }

        if ($this->find($id)) {
            $this->delete($id);  
            return 'Marca eliminada con éxito';
        }

        return 'Marca no encontrada';
    }

    // Método para obtener marcas con el nombre del usuario
    public function getMarcadatos()
    {
        return $this->select('marcas.*, usuarios.nombre_usuario as nombre_usuario')
                    ->join('usuarios', 'usuarios.id_usuario = marcas.id_usuario', 'left') 
                    ->findAll();
    }

    //Vista EditarMarca
    //metodo para mostrar los datos del formulario
    public function obtenerMarcaConUsuario($id_marcas)
    {
        return $this->select('marcas.*, usuarios.nombre_usuario as nombre_usuario')
                    ->join('usuarios', 'usuarios.id_usuario = marcas.id_usuario', 'left') 
                    ->where('id_marcas', $id_marcas)
                    ->first();
    }

    //Metodo para actualizar una marca 
    public function actualizarMarcaa($id, $data)
    {
        return $this->update($id, $data);
    }

    //Metodo para Verificar que la fecha no sea mayor a la actual
    public function validarFechaAudita($fecha_audita)
    {
        $currentDate = date('Y-m-d');
        return strtotime($fecha_audita) <= strtotime($currentDate);
    }
    
}
