<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'tel'=>'required|string|max:20',
            'password'=>'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'tel'=>$request->tel,
            'password'=>Hash::make($request->password),

        ]);
        
        Auth::login($user);

        return redirect('/')->with('success','Kayıt başarılı hoşgeldiniz!');

    }

    
}
