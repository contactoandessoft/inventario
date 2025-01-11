<?php

namespace App\Controllers;

use App\Models\ResponsablesModel;
use App\Models\UsuarioModel;

class ResponsableForm extends BaseController
{
    //Funcion para cargar el formulario de responsable con usuarios activos
    public function index()
    {
        $responsablesModel = new ResponsablesModel();
        $usuariosModel = new UsuarioModel();

        $responsables = $responsablesModel->obtenerResponsablesActivos();  
        $usuarios = $usuariosModel->obtenerUsuariosActivos();  

        return view('responsableform', [
            'responsables' => $responsables,
            'usuarios' => $usuarios
        ]);
    }

    //Funcion para registrar un responsable
    public function registrar()
    {
        $vigencia = $this->request->getPost('vigencia') == 'activo' ? 1 : 0;  
        $fecha_audita = $this->request->getPost('fecha_audita');

        // Validar que la fecha de auditoría no sea posterior a la fecha actual
        if (strtotime($fecha_audita) > time()) {
            return redirect()->to('/responsableform')->withInput()->with('errors', ['fecha_audita' => 'La fecha de auditoría no puede ser posterior a la fecha actual.']);
        }

        $data = [
            'nombre_responsable' => $this->request->getPost('nombre_responsable'),
            'vigencia' => $vigencia, 
            'fecha_audita' => $fecha_audita,
            'id_usuario' => $this->request->getPost('id_usuario'),
        ];

        // Reglas de validación
        $validationRules = [
            'nombre_responsable' => 'required|min_length[3]|is_unique[responsables.nombre_responsable]',  
            'vigencia' => 'required',
            'fecha_audita' => 'required|valid_date',
            'id_usuario' => 'required|is_not_unique[usuarios.id_usuario]',
        ];

        $validationMessages = [
            'nombre_responsable' => [
                'required' => 'El nombre del responsable es obligatorio.',
                'min_length' => 'El nombre del responsable debe tener al menos 3 caracteres.',
                'is_unique' => 'El nombre del responsable ya está registrado.',
            ],
            'vigencia' => [
                'required' => 'La vigencia es obligatoria.',
                'in_list' => 'La vigencia debe ser "Activo" o "Baja".'
            ],
            'fecha_audita' => [
                'required' => 'La fecha de auditoría es obligatoria.',
                'valid_date' => 'La fecha de auditoría debe ser una fecha válida.',
            ],
            'id_usuario' => [
                'required' => 'El usuario es obligatorio.',
                'is_not_unique' => 'El usuario seleccionado no existe.',
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->to('/responsableform')->withInput()->with('errors', $this->validator->getErrors());
        }

        $responsablesModel = new ResponsablesModel();

        // Crear un nuevo responsable
        if ($responsablesModel->registrarResponsable($data)) {
            return redirect()->to('/responsableform')->with('success', 'Responsable registrado correctamente.');
        }

        return redirect()->to('/responsableform')->with('error', 'Error al registrar el responsable.');
    }

    //Funcion para obtener un responsable por su nombre
    public function obtenerResponsable($nombre_responsable)
    {
        $responsablesModel = new ResponsablesModel(); 

        $responsable = $responsablesModel->obtenerResponsablePorNombre($nombre_responsable);

        if ($responsable) {
            return $this->response->setJSON([
                'success' => true,
                'responsable' => $responsable
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false
            ]);
        }
    }
}
