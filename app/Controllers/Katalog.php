<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Katalog extends BaseController
{
    public function index()
    {
        // Pastikan view 'katalog/index' sudah ada nanti
        return view('katalog/index'); 
    }
}