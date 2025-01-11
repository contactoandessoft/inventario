<?php

namespace App\Controllers;

use App\Models\MarcasModel;
use App\Models\UsuarioModel;

class MarcasForm extends BaseController
{
    // Funcion para cargar el formulario de marcas con usuarios activos
    public function index()
    {
        $usuariosModel = new UsuarioModel();
        $usuarios = $usuariosModel->obtenerUsuariosActivos(); 

        return view('marcasform', ['usuarios' => $usuarios]);
    }

    // Funcion para obtener una marca por su nombre
    public function obtenerMarca($nombre_marca)
    {
        $marcasModel = new MarcasModel();

        $marca = $marcasModel->obtenerMarcaPorNombre($nombre_marca);

        if ($marca) {
            return $this->response->setJSON([
                'success' => true,
                'marca' => $marca
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Marca no encontrada'
            ]);
        }
    }

    // Funcion para registrar una marca
    public function registrar()
    {
        $data = $this->request->getPost();

        // Reglas de validación
        $validationRules = [
            'nombre_marca' => 'required|min_length[3]|max_length[100]|is_unique[marcas.nombre_marca]', 
            'vigencia' => 'required|in_list[0,1]',
            'fecha_audita' => 'required|valid_date',
            'id_usuario' => 'required|integer',
        ];
        
        $validationMessages = [
            'nombre_marca' => [
                'required' => 'El nombre de la marca es obligatorio.',
                'min_length' => 'El nombre de la marca debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre de la marca no puede exceder los 100 caracteres.',
                'is_unique' => 'El nombre de la marca ya está registrado.',
            ],
            'vigencia' => [
                'required' => 'La vigencia de la marca es obligatoria.',
                'in_list' => 'La vigencia debe ser "Activo" o "Baja".',
            ],
            'fecha_audita' => [
                'required' => 'La fecha auditada es obligatoria.',
                'valid_date' => 'La fecha auditada debe ser una fecha válida.',
            ],
            'id_usuario' => [
                'required' => 'El usuario es obligatorio.',
                'integer' => 'El ID del usuario debe ser un número entero.',
            ],
        ];

        // Validar los datos del formulario
        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validación para asegurarse de que la fecha no sea futura
        $fechaIngresada = strtotime($data['fecha_audita']);
        $fechaActual = strtotime(date('Y-m-d'));

        if ($fechaIngresada > $fechaActual) {
            return redirect()->back()->withInput()->with('errors', [
                'fecha_audita' => 'La fecha auditada no puede ser una fecha futura.'
            ]);
        }

        $marcasModel = new MarcasModel();

        $marcaData = [
            'nombre_marca' => $data['nombre_marca'],
            'vigencia' => (int)$data['vigencia'],
            'fecha_audita' => $data['fecha_audita'],
            'id_usuario' => $data['id_usuario'],
        ];

        if ($marcasModel->registrarMarca($marcaData)) {
            return redirect()->to('/marcasform')->with('success', 'Marca registrada con éxito.');
        } else {
            return redirect()->back()->with('error', 'Hubo un problema al registrar la marca.');
        }
    }
}
