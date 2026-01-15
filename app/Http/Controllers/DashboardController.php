<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function setActive($page)
    {
        return [
            'Dashboard' => $page,
            'DashboardActive'  => true,
        ];
    }
    public function index()
    {
        return view('welcome', $this->setActive('dashboard'));
    }
}
