<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('pages.user.index');
    }

    public function create(){
        return view('pages.user.create');

    }

    public function edit(){
        return view('pages.user.edit');

    }

    public function update(){

    }

    public function delete(){

    }
}
