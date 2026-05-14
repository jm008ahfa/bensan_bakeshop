<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $currentPath = $request->getUri()->getPath();
        $currentPath = ltrim($currentPath, '/');
        
        // Public paths that don't require login
        $publicPaths = [
            '',
            'login',
            'auth/doLogin',
            'register',
            'auth/doRegister'
        ];
        
        // Check if public path
        foreach ($publicPaths as $path) {
            if ($currentPath === $path) {
                return;
            }
        }
        
        // Check if logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        // Get user role
        $role = session()->get('role');
        
        // Staff allowed paths
        $staffAllowedPaths = [
            'pos',
            'order-confirmation',
            'order-confirmation/pending',
            'order-confirmation/preparing',
            'order-confirmation/ready',
            'order-confirmation/completed',
            'order-confirmation/confirm',
            'order-confirmation/markReady',
            'order-confirmation/markReadyForRider',
            'order-confirmation/markCompleted',
            'order-confirmation/cancel',
            'order-confirmation/view',
            'logout'
        ];
        
        // If staff, check access
        if ($role === 'staff') {
            // Redirect dashboard to POS
            if ($currentPath === 'dashboard') {
                return redirect()->to('/pos');
            }
            
            // Check if path is allowed
            $allowed = false;
            foreach ($staffAllowedPaths as $allowedPath) {
                if (strpos($currentPath, $allowedPath) === 0) {
                    $allowed = true;
                    break;
                }
            }
            
            // If not allowed, redirect to POS
            if (!$allowed) {
                return redirect()->to('/pos');
            }
        }
        
        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing needed
    }
}