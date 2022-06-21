<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function users()
    {
        $users = User::all();
        return Inertia::render('Users/Index', ['users' => $users]);
    }
    public function create(Request $request){
        return Inertia::render('Users/Create');
    }
    public function edit(User $user){
   
    }
}
