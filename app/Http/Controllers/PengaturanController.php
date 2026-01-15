<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    private function setActive($page)
    {
        return [
            'activePengaturan' => $page,
            'pengaturanActive'  => true,
        ];
    }
    public function index()
    {
        return view('pengaturan.index', $this->setActive('pengaturan'));
    }
}
