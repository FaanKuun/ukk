<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        $data = [
            "email" => $request->email,
            "password" => $request->password
        ];

        if (Auth::attempt($data)) {
            return redirect("/");
        }
        return redirect()->back();
    }

    public function logout(){
        Auth::logout();
        return redirect()->back();

    }

    public function register(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->username = $request->username;

        $user->save();


        return redirect("/register");
    }
}
