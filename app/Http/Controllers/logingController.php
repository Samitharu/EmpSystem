<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class logingController extends Controller
{
    public function loging(Request $request){
        //dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed
            $user = Auth::user();
            $employee = Employee::find($user->employeeId);
           
            //Setting first Name to session
            session()->put('userName', $employee->firstName);
            return response()->json(['status'=>200]); 
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    //Log out function 
    public function logout(){
        Auth::logout();
        session()->flush();
        return redirect('/');
    }
}
