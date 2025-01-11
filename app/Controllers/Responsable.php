<?php

namespace App\Controllers;

use App\Models\ResponsablesModel;

class Responsable extends BaseController
{
    public function index()
    {
        $responsablesModel = new ResponsablesModel();
        $responsables = $responsablesModel->obtenerResponsablesConUsuario();
        
        return view('responsable', ['responsables' => $responsables]);
    }

    //Funcion para eliminar responsable
    public function eliminar($id_responsable)
    {
        $responsablesModel = new ResponsablesModel();

        // Verificar si el responsable está en uso
        $responsableEnUso = $responsablesModel->responsableEnUso($id_responsable);

        if ($responsableEnUso) {
            return redirect()->back()->with('error', 'Este responsable está siendo utilizado en un formulario y no se puede eliminar.');
        } else {
            $responsablesModel->delete($id_responsable);
            return redirect()->to('/responsable')->with('success', 'Responsable eliminado correctamente.');
        }
    }
}
