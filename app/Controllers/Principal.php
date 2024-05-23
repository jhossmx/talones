<?php

namespace App\Controllers;

class Principal extends BaseController
{

    public function __construct()
    {
    }

    public function index()
    {

        //$data['css'] = ['prueba', 'prueba2'];
        //$data['js'] = ['pruebajs1', 'pruebajs2'];
        $data['js'] = ['principal/principal'];
        return view('principal/index', $data);
    }
}