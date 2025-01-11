<?php

namespace App\Controllers;

use App\Models\FormularioModel;

class Formulario extends BaseController
{
    public function index()
    {
        $formularioModel = new FormularioModel();

        $marcas = $formularioModel->getMarcas();
        $responsables = $formularioModel->getResponsables();
        $tipo_equipo = $formularioModel->getTipoEquipo();

        return view('formulario', [
            'marcas' => $marcas,
            'responsables' => $responsables,
            'tipo_equipo' => $tipo_equipo,
            'mensaje' => session()->getFlashdata('mensaje'),
            'errors' => session()->getFlashdata('errors'),
            'formData' => session()->getFlashdata('formData')
        ]);
    }

    // Funcion para obtener el nombre de inventario
    public function obtenerEquipo($numero_inventario)
    {
        $formularioModel = new FormularioModel();

        $equipo = $formularioModel->obtenerEquipoPorInventario($numero_inventario);

        if ($equipo) {
            return $this->response->setJSON([
                'success' => true,
                'equipo' => $equipo
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false
            ]);
        }
    }

    public function registrar()
    {
        $formularioModel = new FormularioModel();
        $currentYear = date('Y');
        $currentDate = date('Y-m-d'); 
        $validation = \Config\Services::validation();

        // Reglas de validación
        $validation->setRules([
            'numero_inventario' => 'required|min_length[3]|max_length[50]|is_unique[formulario.numero_inventario]', 
            'descripcion' => 'required|min_length[3]|max_length[255]',
            'id_marcas' => 'required|is_natural_no_zero',
            'modelo' => 'required|min_length[3]|max_length[100]',
            'ano_fabricacion' => "required|numeric|less_than_equal_to[{$currentYear}]",
            'valor_adquisicion' => 'required|numeric',
            'id_responsable' => 'required|is_natural_no_zero',
            'estado' => 'required|in_list[Activo,Baja]',
            'vida_util' => 'required|numeric|greater_than[0]',
        ], [
            'numero_inventario' => [
                'required' => 'El número de inventario es obligatorio.',
                'min_length' => 'El número de inventario debe tener al menos 3 caracteres.',
                'max_length' => 'El número de inventario no puede tener más de 50 caracteres.',
                'is_unique' => 'El número de inventario ya está registrado.',
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
                'less_than_equal_to' => 'El año de fabricación no puede ser mayor al año actual.',
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
            
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $numero_inventario = $this->request->getVar('numero_inventario');

            // Verificar si el equipo ya existe en la base de datos
            $equipoExistente = $formularioModel->where('numero_inventario', $numero_inventario)->first();

            if ($equipoExistente) {
                session()->setFlashdata('mensaje', 'Este equipo ya está registrado y no puede ser editado.');
                return redirect()->to('/formulario');
            }

            // Subir la imagen si fue seleccionada
            $imagen = $this->request->getFile('imagen');
            if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
                $nuevoNombre = $numero_inventario . '.' . $imagen->getExtension();
                $imagen->move(ROOTPATH . 'public/uploads', $nuevoNombre);
            }

            $data = [
                'numero_inventario' => $this->request->getVar('numero_inventario'),
                'descripcion' => $this->request->getVar('descripcion'),
                'id_marcas' => $this->request->getVar('id_marcas'),
                'modelo' => $this->request->getVar('modelo'),
                'ano_fabricacion' => $this->request->getVar('ano_fabricacion'),
                'valor_adquisicion' => $this->request->getVar('valor_adquisicion'),
                'id_responsable' => $this->request->getVar('id_responsable'),
                'estado' => $this->request->getVar('estado'),
                'numero_serie' => $this->request->getVar('numero_serie'),
                'vida_util' => $this->request->getVar('vida_util'),
                'fecha_alta' => $this->request->getVar('fecha_alta'),
                'seccion' => $this->request->getVar('seccion'),
                'dependencia' => $this->request->getVar('dependencia'),
                'comentarios' => $this->request->getVar('comentarios'),
            ];

            $formularioModel->save($data);
            session()->setFlashdata('mensaje', 'Equipo registrado correctamente.');

            return redirect()->to('/formulario');
        } else {
            return redirect()->to('/formulario')->withInput()->with('errors', $validation->getErrors());
        }
    }
}
