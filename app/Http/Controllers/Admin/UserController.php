<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus($Id)
    {
        $user = User::findorFail($Id);
        $user->is_active = !$user->is_active;
        $user->save();
        $status = $user->is_active? 'activated' : 'deactivated';

      
        return back()->with('success', "User {$user->name} email {$user->email} has been {$status} successfully");
    }
}
