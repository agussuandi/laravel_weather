<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Hash;
use Auth;
use Session;
use Exception;

use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if ($request->isMethod('post'))
        {
            try
            {
                DB::beginTransaction();
                $user                   = new User;
                $user->username         = ucwords(strtolower($request->username));
                $user->name             = $request->name;
                $user->email            = strtolower($request->email);
                $user->password         = Hash::make($request->password);
                $user->created_at       = date('Y-m-d H:i:s');
                $simpan = $user->save();
                DB::commit();
            }
            catch (Exception $e)
            {
                DB::rollBack();
            }
        }
        return view('auth.register');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post'))
        {
            try
            {
                $data = [
                    'username'  => $request->username,
                    'password'  => $request->password
                ];

                Auth::attempt($data);
                if (Auth::check())
                {
                    return redirect('home');
                }
                else
                {
                    Session::flash('error', 'Email atau password salah');
                    return redirect('/');
                }
            }
            catch (Exception $e)
            {
                Session::flash('error', 'Email atau password salah');
                return redirect('/');
            }
        }
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
