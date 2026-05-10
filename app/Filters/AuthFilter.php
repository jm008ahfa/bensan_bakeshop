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
        
        // Remove leading slash for easier matching
        $currentPath = ltrim($currentPath, '/');
        
        // Define public paths that don't require login
        $publicPaths = [
            '',
            'login',
            'auth/doLogin',
            'register',
            'auth/doRegister',
            'customer',
            'customer/login',
            'customer/register',
            'customer/auth/doLogin',
            'customer/auth/doRegister'
        ];
        
        // Check if current path is public (no login required)
        foreach ($publicPaths as $path) {
            if ($currentPath === $path) {
                return;
            }
        }
        
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        // Get user role
        $role = session()->get('role');
        
        // Define allowed paths for staff (redirect to POS instead of dashboard)
        $staffAllowedPaths = [
            'pos',
            'order-confirmation',
            'order-confirmation/pending',
            'order-confirmation/preparing',
            'order-confirmation/ready',
            'order-confirmation/completed',
            'order-confirmation/confirm',
            'order-confirmation/markReady',
            'order-confirmation/markCompleted',
            'order-confirmation/cancel',
            'order-confirmation/view',
            'logout'
        ];
        
        // If user is staff
        if ($role === 'staff') {
            // Check if trying to access dashboard (not allowed)
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
            
            if (!$allowed) {
                return redirect()->to('/pos')->with('error', 'Access denied. Staff can only access POS and Online Orders.');
            }
        }
        
        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing needed here
    }
}