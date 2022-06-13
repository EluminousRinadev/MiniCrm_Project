<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\Company;
use Auth;
use Redirect;
class AuthController extends Controller
{
    public function __construct(){

        $this->Employee = new Employee();
        $this->BaseModel=$this->Employee;
        $this->arr_view_data      = [];
        $this->module_view_folder = "auth";
  


    }
    public function login(){

        return view('auth.login');
    }
    
    public function login_process(Request $request){

            $arr_rules = [];
            
            $arr_rules['email']        = 'required';
            $arr_rules['password']     = 'required';
            

            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
         
              return Redirect::back()->withErrors($validator);
            }
        
          else
          {
            $userdata = array(
                'email' => $request->input('email') ,
                'password' => $request->input('password')
              );
    
         if (Auth::attempt($userdata))
            {
             

                return redirect()->route('admin.company');
                
               
            }
            else
            {
            return back()->with('error','Login Failed Wrong User Credentials');
            
            }
          }
        }

        function logout()
        {
                Auth::logout(); // logging out user
                return Redirect::to('login'); // redirection to login screen
        }
    
    

}
