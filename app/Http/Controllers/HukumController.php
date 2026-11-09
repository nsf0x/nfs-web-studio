<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HukumController extends Controller
{
    public function privasi(): View
    {
        return view('hukum.privasi');
    }

    public function syarat(): View
    {
        return view('hukum.syarat');
    }
}
