<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    //|is_unique[s_usuarios.da_email]
    //reglas de validacion para el login
    public $login = [ 
        'txt_correo' => [
            'label' => 'Correo Elecrtrónico',
            'rules' => 'required|valid_email|max_length[120]',
            'errors' => [
                'required' => 'El {field} es requerido.',
                'valid_email' => 'El {field} debe contener un formato de correo electrónico válido',
                'max_length' => 'El <b>{field}</b> debe contener m&aacute;ximo {param} caracteres',
                //'is_unique' => 'El correo eletrónico ya se encuentra registrado'
            ]
        ],
        'txt_clave' => [
            'label' => 'Contraseña',
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => 'La {field} es requerida.',
                'max_length' => 'La <b>{field}</b> debe contener m&aacute;ximo {param} caracteres',
            ]
        ],
    ];

    //reglas de validacion para el registro de un nuevo usuario
    public $registrar = [ 
        'txt_correo' => [
            'label' => 'Correo Elecrtrónico',
            'rules' => 'required|valid_email|max_length[100]|is_unique[s_usuarios.da_email]',
            'errors' => [
                'required' => 'El {field} es requerido.',
                'valid_email' => 'El {field} debe contener un formato de correo electrónico válido',
                'max_length' => 'El <b>{field}</b> debe contener m&aacute;ximo {param} caracteres',
                'is_unique' => 'El correo eletrónico ya se encuentra registrado'
            ]
        ],
        'txt_ap1' => [
            'label' => 'Primer Apellido',
            'rules' => 'required|max_length[60]|alpha_space',
            'errors' => [
                'required' => 'El {field} es requerido.',
                'max_length' => 'El <b>{field}</b> debe contener m&aacute;ximo {param} caracteres',
                'alpha_space' => 'El {field} solo puede contener letras y espacios.',
            ]
        ],
        'txt_ap2' => [
            'label' => 'Segundo Apellido',
            'rules' => 'permit_empty|max_length[60]|alpha_space',
            'errors' => [
                'max_length' => 'El <b>{field}</b> debe contener m&aacute;ximo {param} caracteres',
                'alpha_space' => 'El {field} solo puede contener letras y espacios.',
            ]
        ],
        'txt_nombre' => [
            'label' => 'Nombre',
            'rules' => 'required|max_length[60]|alpha_space',
            'errors' => [
                'required' => 'El {field} es requerido.',
                'max_length' => 'El <b>{field}</b> debe contener m&aacute;ximo {param} caracteres',
                'alpha_space' => 'El {field} solo puede contener letras y espacios.',
            ]
        ],
        'txt_clave' => [
            'label' => 'Contraseña',
            'rules' => 'required|max_length[80]|alpha_numeric',
            'errors' => [
                'required' => 'La {field} es requerida.',
                'max_length' => 'La <b>{field}</b> debe contener m&aacute;ximo {param} caracteres',
                'alpha_numeric' => 'La {field} solo puede contener letras y numeros.',
            ]
        ],
    ];

}
