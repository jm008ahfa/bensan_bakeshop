<?php

namespace App\Controllers;

class Notification extends BaseController
{
    public function __construct()
    {
        if (!session()->get('logged_in')) {
            redirect()->to('/login');
        }
    }
    
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Get unread notifications count
        $unreadCount = $db->table('notifications')
                          ->where('is_read', 0)
                          ->countAllResults();
        
        // Get all notifications
        $notifications = $db->table('notifications')
                            ->orderBy('created_at', 'DESC')
                            ->limit(50)
                            ->get()
                            ->getResultArray();
        
        $data = [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ];
        
        return view('template', [
            'title' => 'Notifications',
            'active_menu' => 'notifications',
            'content' => view('notification/index', $data)
        ]);
    }
    
    public function markRead($id)
    {
        $db = \Config\Database::connect();
        $db->table('notifications')->where('id', $id)->update(['is_read' => 1]);
        return redirect()->to('/notifications');
    }
    
    public function markAllRead()
    {
        $db = \Config\Database::connect();
        $db->table('notifications')->update(['is_read' => 1]);
        return redirect()->to('/notifications');
    }
    
    public function getUnreadCount()
    {
        $db = \Config\Database::connect();
        $count = $db->table('notifications')
                    ->where('is_read', 0)
                    ->countAllResults();
        return $this->response->setJSON(['count' => $count]);
    }
}