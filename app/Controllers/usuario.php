<?php

namespace App\Controllers;

use App\Models\usuarioModel;
use App\Models\TipoCuentaModel;
use App\Models\ResponsablesModel;


class Usuario extends BaseController
{
    public function index()//: string
    {
        return view('register');
    }

    public function create()
{
    // Definir las reglas de validación
    $rules = [
        'user' => 'required|max_length[100]|is_unique[usuarios.user]',
        'clave' => 'required|max_length[100]|min_length[5]',
        'repassword' => 'matches[clave]',
        'nombre_usuario' => 'required|max_length[100]',
        'correo' => 'required|max_length[100]|valid_email|is_unique[usuarios.correo]',
    ];

    // Validar los datos de entrada
    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
    }

 
    $usuarioModel = new usuarioModel();
    $post = $this->request->getPost(['user', 'clave', 'nombre_usuario', 'correo']);

    
    $usuarioModel->insert([
        'user' => $post['user'],
        'clave' => password_hash($post['clave'], PASSWORD_DEFAULT),
        'nombre_usuario' => $post['nombre_usuario'],
        'correo' => $post['correo'],
        'vigencia' => 1,
    ]);

   
    $idUsuario = $usuarioModel->getInsertID();

   
    $tipoCuentaModel = new TipoCuentaModel();

    // Obtener el último valor de 'num_cuenta' para incrementar
    $lastNumCuenta = $tipoCuentaModel->selectMax('num_cuenta')->first();
    $newNumCuenta = ($lastNumCuenta['num_cuenta']) ? $lastNumCuenta['num_cuenta'] + 1 : 1;

    // Verificar si el 'num_cuenta' generado ya existe
    $existingCuenta = $tipoCuentaModel->where('num_cuenta', $newNumCuenta)->first();
    if ($existingCuenta) {
        $newNumCuenta++;
    }

    $tipoCuentaModel->insert([
        'num_cuenta' => $newNumCuenta,
        'descripcion' => $post['nombre_usuario'], 
        'vigencia' => 1,
        'fecha_audita' => null,
        'id_usuario' => $idUsuario,
    ]);


    $responsablesModel = new ResponsablesModel();
    $responsablesModel->insert([
        'nombre_responsable' => $post['nombre_usuario'],
        'vigencia' => 1, 
        'id_usuario' => $idUsuario, 
    ]);

    // Redirigir con éxito
    return redirect()->to(base_url())->with('success', 'Registro exitoso. Por favor, inicia sesión.');
}

    public function linkrequestform()//: string
    {
        return view('linkrequest');
    }
}