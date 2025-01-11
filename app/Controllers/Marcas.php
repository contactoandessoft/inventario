<?php

namespace App\Controllers;

use App\Models\MarcasModel;

class Marcas extends BaseController
{
    public function index()
    {
        $marcasModel = new MarcasModel();
        $data['marcas'] = $marcasModel->getMarcadatos(); 

        return view('marcas', $data); 
    }

    //Funcion para eliminar una marca
    public function eliminar($id)
    {
        $marcasModel = new MarcasModel();
        $resultado = $marcasModel->eliminarMarca($id);

        if ($resultado === 'Marca eliminada con éxito') {
            return redirect()->to(base_url('marcas'))->with('message', $resultado);
        }

        return redirect()->to(base_url('marcas'))->with('error', $resultado);
    }
}
