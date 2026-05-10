<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $currentPath = $request->getUri()->getPath();
        
        // Define public customer paths that don't require login
        $publicPaths = [
            'customer/login',
            'customer/register',
            'customer/auth/doLogin',
            'customer/auth/doRegister'
        ];
        
        // Check if current path is public
        foreach ($publicPaths as $path) {
            if (strpos($currentPath, $path) !== false) {
                return;
            }
        }
        
        // Check if customer is logged in
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('/customer/login');
        }
        
        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing needed here
    }
}