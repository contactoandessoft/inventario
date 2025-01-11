<?php

namespace App\Controllers;

use App\Models\MarcasModel;
use App\Models\usuarioModel;

class EditarMarca extends BaseController
{
    // Funcion para mostrar una marca existente
    public function index($id_marcas)
    {
        $marcasModel = new MarcasModel();
        $usuariosModel = new usuarioModel();

        $marca = $marcasModel->obtenerMarcaConUsuario($id_marcas);

        if (!$marca) {
            return redirect()->to('/marcas')->with('errors', ['Marca no encontrada']);
        }

        $usuarios = $usuariosModel->obtenerUsuariosActivos();

        return view('editarmarca', ['marca' => $marca, 'usuarios' => $usuarios]);
    }

    // Funcion para actualizar una marca existente
    public function actualizar()
    {
        $marcasModel = new MarcasModel();

        // Reglas de validación
        $validationRules = [
            'nombre_marca' => ['rules' => 'required|min_length[3]|max_length[100]'],
            'vigencia' => ['rules' => 'required|in_list[0,1]'],
            'fecha_audita' => ['rules' => 'required|valid_date'],
            'id_usuario' => ['rules' => 'required|integer'],
        ];

        $validationMessages = [
            'nombre_marca' => [
                'required' => 'El nombre de la marca es obligatorio.',
                'min_length' => 'El nombre de la marca debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre de la marca no puede exceder los 100 caracteres.',
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

        foreach ($validationRules as $key => &$rule) {
            $rule['errors'] = $validationMessages[$key];
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validar que la fecha auditada no supere la fecha actual
        $fechaAudita = $this->request->getPost('fecha_audita');
        $currentDate = date('Y-m-d');
        if (strtotime($fechaAudita) > strtotime($currentDate)) {
            return redirect()->back()->withInput()->with('errors', ['La fecha de auditoría no puede ser posterior a la fecha actual.']);
        }

        $data = [
            'id_marcas' => $this->request->getPost('id_marcas'),
            'nombre_marca' => $this->request->getPost('nombre_marca'),
            'vigencia' => $this->request->getPost('vigencia'),
            'fecha_audita' => $fechaAudita,
            'id_usuario' => $this->request->getPost('id_usuario'),
        ];

        // Llamar al método del modelo para actualizar la marca
        $updated = $marcasModel->actualizarMarcaa($data['id_marcas'], $data);

        if ($updated) {
            return redirect()->to('/editarmarca/' . $data['id_marcas'])->with('success', 'Marca actualizada exitosamente');
        } else {
            return redirect()->back()->with('errors', ['Error al actualizar la marca']);
        }
    }
}
