<?php

namespace App\Controllers;
use App\Models\HomeModel;
use App\Models\FormularioModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new FormularioModel();
        
        
        $equipos = $model->getEquipos();

        
        return view('home', [
            'equipos' => $equipos, 
        ]);
    }
}
