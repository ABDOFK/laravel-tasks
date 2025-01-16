<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function formulaire()
    {
        return view('form');
    }
    public function enregistre(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');


        return view('result', compact('name', 'email', 'password'));
    }
}
