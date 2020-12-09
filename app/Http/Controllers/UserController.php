<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '<>', 'admin')
            ->orWhereNull('role')
            ->orderByRaw('name ASC')
            ->get();
        return view('user.index', compact('users'));
    }

    public function aktivasi(User $user)
    {
        User::where('id', $user->id)
            ->update(['role' => 'user']);
        return redirect('/user')->with('update', 'Data User Berhasil Diaktivasi');
    }
}
