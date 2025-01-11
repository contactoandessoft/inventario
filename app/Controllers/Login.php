<?php

namespace App\Controllers;
use App\Models\usuarioModel;



class Login extends BaseController
{
    public function index()//: string
    {
        return view('login');
    }

    public function auth(){
        $rules = [
            'user' => 'required',
            'clave' => 'required',

        ];
        
        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $usuarioModel = new usuarioModel();
        $post = $this->request->getPost(['user','clave']);

        $user = $usuarioModel->validateUser($post['user'],$post['clave']);
    
        if($user !== null){
            $this->setSession($user);
            return redirect()->to(base_url('home'));
        }
        return redirect()->back()->withInput()->with('errors', 'El usuario y/o contraseña son incorrectos');

    }

    private function setSession($userData){
        $data=[
            'logged_in' => true,
            'userid' => $userData['id_usuario'],
            'username' => $userData['nombre_usuario'],
        ];

        $this->session->set($data);
    }

    //la sesion fue iniciada correctamente y despues debe ser destruida
    public function logout(){
        if($this->session->get('loggen_in')){
            $this->session->destroy();
        }
        return redirect()->to(base_url());
    }
}