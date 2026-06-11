<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
   public function showLoginForm(Request $request): View
    {
        return view('admin.login');
    }
}
