<?php
namespace App\Controllers;
use App\Models\UserModel;

class Login extends BaseController
{
    //https: //www.tutsmake.com/codeigniter-4-login-and-registration-tutorial-example/
    private $model = '';
    private $validation = array();
    public function __construct()
    {
        helper(['html', 'form']);
        $this->validation =  \Config\Services::validation();
        $this->model = new UserModel();
    }

    public function index()
    {
        $data =[];
        //$data['css'] = ['prueba', 'prueba2'];
        //$data['js'] = ['login/login'];
        return view('site/login/login', $data);
    }

    public function registro()
    {
        $data = [];
        return view('site/login/register', $data);
    }

    public function registrar()
    {
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $data = $_POST;
            //echo print_r($data);exit;
            if(!$this->validation->run($data, 'registrar')) {
                //No paso validaciones del registro
                //var_dump( $this->validation->getErrors());
                //echo print_r($this->validator); exit;
                return view('site/login/register', ["validation" =>  $this->validation->getErrors()]);
            }else{
                //echo print_r($_POST);exit;
                $password = trim($this->request->getVar('txt_clave'));
                $ap2 = strtoupper(trim($this->request->getVar('txt_ap2')));
                
                $infoUser = [
                    'cn_id'     => 0,
                    'da_email'  => strtolower(trim($this->request->getVar('txt_correo'))),
                    'da_clave'  => password_hash( $password, PASSWORD_DEFAULT),
                    'da_apell1' => strtoupper(trim($this->request->getVar('txt_ap1'))),
                    'da_apell2' => strtoupper(trim($this->request->getVar('txt_ap2'))),
                    'da_nombre' => strtoupper(trim($this->request->getVar('txt_nombre'))),
                    'fn_tipousuario' => 2,
                    'da_status' => 'A'
                ];
                $userId = $this->model->registrar($infoUser);
                //echo $userId; exit;
                if ($userId > 0) {
                    $infoUser['cn_id'] = $userId;
                    $this->setUserSession($infoUser);
                    return redirect()->to('principal'); 
                }else{
                    return view('site/login/register');
                }
            }
        }    
        //echo "llega";exit;
        //return view('site/login/register', $data);
    }

    public function validalogin()
    {
        //echo print_r($_POST);exit;

        $data = [];
        if ($this->request->getMethod() == 'post') {

            $data = $_POST;

            //archivo de validaciones en app\config\Validation.php
            if(!$this->validation->run($data, 'login')) {
                //No paso validaciones de login
                return view('site/login/login', ["validation" => $this->validator]);

            } else {

                //echo "paso validacion"; exit;

                $session = session();
                $email = strtolower(trim($this->request->getVar('txt_correo')));
                $password = trim($this->request->getVar('txt_clave'));
                $user = $this->model->where('da_email', $email)->first();
                if ($user) {
                    $passDb = $user['da_clave'];
                    $verify_pass = password_verify($password, $passDb);
                    if ($verify_pass) {
                        $this->setUserSession($user);
                        return redirect()->to('principal'); 
                        //return view('principal/index');
                    }
                } else {
                    $session->setFlashdata('msg', 'Invalid User');
                    return view('site/login/login');
                }
            }
        }
        return view('site/login/login');
    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['cn_id'],
            'correo' => $user['da_email'],
            'ap1' => $user['da_apell1'],
            'ap2' => $user['da_apell2'],
            'nombre' => $user['da_nombre'],
            'tipo'   => $user['fn_tipousuario'],
            'isLoggedIn' => true,
        ];
        session()->set($data);
        return true;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}