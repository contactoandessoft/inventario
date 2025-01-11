<?php

namespace App\Controllers;

use App\Models\ResponsablesModel;
use App\Models\UsuarioModel;

class EditarResponsable extends BaseController
{

    //Funcion para mostrar los datos del responsable
    public function index($id_responsable)
    {
        $responsablesModel = new ResponsablesModel();
        $usuarioModel = new UsuarioModel();

        $responsable = $responsablesModel->obtenerPorId($id_responsable);

        if (!$responsable) {
            return redirect()->to('/responsables')->with('error', 'No se encontró el responsable.');
        }

        $usuarios = $usuarioModel->obtenerUsuariosActivos();

        return view('editarresponsable', [
            'responsable' => $responsable,
            'usuarios' => $usuarios,
        ]);
    }

    //Funcion para actualizar un responsable
    public function actualizar()
    {
        $id_responsable = $this->request->getPost('id_responsable');
        $nombre_responsable = $this->request->getPost('nombre_responsable');
        $vigencia = $this->request->getPost('vigencia');
        $fecha_audita = $this->request->getPost('fecha_audita');
        $id_usuario = $this->request->getPost('id_usuario');

        $responsablesModel = new ResponsablesModel();
        if (!$responsablesModel->validarFechaAudita($fecha_audita)) {
            return redirect()->back()->withInput()->with('errors', [
                'fecha_audita' => 'La fecha de auditoría no puede ser posterior a la fecha actual.'
            ]);
        }

        // Reglas de validación
        $validationRules = [
            'nombre_responsable' => 'required|min_length[3]',
            'vigencia' => 'required',
            'fecha_audita' => 'required|valid_date',
            'id_usuario' => 'required|is_not_unique[usuarios.id_usuario]',
        ];

        $validationMessages = [
            'nombre_responsable' => [
                'required' => 'El nombre del responsable es obligatorio.',
                'min_length' => 'El nombre del responsable debe tener al menos 3 caracteres.',
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

        // Validación de los datos
        $validation = \Config\Services::validation();
        $validation->setRules($validationRules, $validationMessages);

        if (!$validation->run([
            'nombre_responsable' => $nombre_responsable,
            'vigencia' => $vigencia,
            'fecha_audita' => $fecha_audita,
            'id_usuario' => $id_usuario
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $responsableData = [
            'nombre_responsable' => $nombre_responsable,
            'vigencia' => $vigencia,
            'fecha_audita' => $fecha_audita,
            'id_usuario' => $id_usuario
        ];

        $updateResult = $responsablesModel->actualizarResponsablee($id_responsable, $responsableData);

        if ($updateResult) {
            return redirect()->to('editarresponsable/' . $id_responsable)->with('success', 'Responsable actualizado con éxito');
        } else {
            return redirect()->to('/responsable')->with('errors', ['No se encontró el responsable']);
        }
    }
}
