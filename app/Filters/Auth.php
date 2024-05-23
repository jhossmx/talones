<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        //return redirect()->to('url');  url
        //return redirect()->route('named_route'); alias

        //echo "entra al filtro";exit;    
        if (session()->get('isLoggedIn') == NULL) {
            return redirect()->route('login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
       
    }
}