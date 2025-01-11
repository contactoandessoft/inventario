<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FormularioModel;

class EditarForm extends Controller
{
    public function index($id_formulario)
    {
        $formularioModel = new FormularioModel();

        $equipo = $formularioModel->find($id_formulario);

        if (!$equipo) {
            return redirect()->to('/home')->with('error', 'Equipo no encontrado');
        }

        // Obtener las marcas, responsables y tipo de equipo desde el modelo
        $marcas = $formularioModel->getMarcas();
        $responsables = $formularioModel->getResponsables();
        $tipo_equipo = $formularioModel->getTipoEquipo();

        return view('editar', [
            'equipo' => $equipo,
            'marcas' => $marcas,
            'responsables' => $responsables,
            'tipo_equipo' => $tipo_equipo
        ]);
    }

    // Funcion para actualizar un Equipo
    public function actualizar($id_formulario)
    {
        $formularioModel = new FormularioModel();

        $currentYear = date('Y');

        $data = $this->request->getPost();

        $validation = \Config\Services::validation();

        // Reglas de validación
        $validation->setRules([
            'numero_inventario' => 'required|min_length[3]|max_length[50]',
            'descripcion' => 'required|min_length[3]|max_length[255]',
            'id_marcas' => 'required|is_natural_no_zero',
            'modelo' => 'required|min_length[3]|max_length[100]',
            'ano_fabricacion' => "required|numeric|less_than_equal_to[$currentYear]",
            'valor_adquisicion' => 'required|numeric',
            'id_responsable' => 'required|is_natural_no_zero',
            'estado' => 'required|in_list[Activo,Baja]',
            'vida_util' => 'required|numeric|greater_than[0]',
            'fecha_alta' => [
                'is_valid_fecha_audita' => function($fecha_alta) use ($formularioModel) {
                    if (!empty($fecha_alta)) {
                        return $formularioModel->validarFechaAlta($fecha_alta);
                    }
                    return true; 
                }
            ],
        ], [
            'numero_inventario' => [
                'required' => 'El número de inventario es obligatorio.',
                'min_length' => 'El número de inventario debe tener al menos 3 caracteres.',
                'max_length' => 'El número de inventario no puede tener más de 50 caracteres.',
            ],
            'descripcion' => [
                'required' => 'La descripción es obligatoria.',
                'min_length' => 'La descripción debe tener al menos 3 caracteres.',
                'max_length' => 'La descripción no puede tener más de 255 caracteres.',
            ],
            'id_marcas' => [
                'required' => 'La marca es obligatoria.',
                'is_natural_no_zero' => 'Selecciona una marca válida.',
            ],
            'modelo' => [
                'required' => 'El modelo es obligatorio.',
                'min_length' => 'El modelo debe tener al menos 3 caracteres.',
                'max_length' => 'El modelo no puede tener más de 100 caracteres.',
            ],
            'ano_fabricacion' => [
                'required' => 'El año de fabricación es obligatorio.',
                'numeric' => 'El año de fabricación debe ser un número.',
                'less_than_equal_to' => "El año de fabricación no puede ser mayor al año actual ($currentYear).",
            ],
            'valor_adquisicion' => [
                'required' => 'El valor de adquisición es obligatorio.',
                'numeric' => 'El valor de adquisición debe ser un número.',
            ],
            'id_responsable' => [
                'required' => 'El responsable es obligatorio.',
                'is_natural_no_zero' => 'Selecciona un responsable válido.',
            ],
            'estado' => [
                'required' => 'El estado es obligatorio.',
                'in_list' => 'El estado debe ser "Activo" o "Baja".',
            ],
            'vida_util' => [
                'required' => 'La vida útil es obligatoria.',
                'numeric' => 'La vida útil debe ser un número.',
                'greater_than' => 'La vida útil debe ser mayor que 0.',
            ],
            'fecha_alta' => [
                'is_valid_fecha_audita' => 'La fecha de alta no puede ser posterior a la fecha actual.'
            ]
        ]);

        if (!$validation->run($data)) {
            return redirect()->to('/editar/' . $id_formulario)->withInput()->with('errors', $validation->getErrors());
        }

        if (!$formularioModel->actualizarEquipo($id_formulario, $data)) {
            return redirect()->to('/editar/' . $id_formulario)->with('error', 'Hubo un error al actualizar el equipo');
        }

        // Obtener el número de inventario y el archivo de la imagen
        $numero_inventario = $this->request->getVar('numero_inventario');
        $imagen = $this->request->getFile('imagen');

        $equipoExistente = $formularioModel->where('numero_inventario', $numero_inventario)->first();

        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $rutaDestino = ROOTPATH . 'public/uploads/';

            if ($equipoExistente) {
                $imagenAnterior = $rutaDestino . $equipoExistente['numero_inventario'] . '.' . $imagen->getExtension();
                if (file_exists($imagenAnterior)) {
                    unlink($imagenAnterior); 
                }
            }

            $nuevoNombre = $numero_inventario . '.' . $imagen->getExtension();
            $imagen->move($rutaDestino, $nuevoNombre); 
        }

        return redirect()->to('/editar/' . $id_formulario)->with('mensaje', 'Equipo actualizado con éxito');
    }
}
