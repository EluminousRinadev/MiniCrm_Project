<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Falsh;
use DB;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{

    public function __construct(){

        $this->Employee           = new Employee();
        $this->BaseModel          = $this->Employee;
        $this->Company            = new Company();
        $this->arr_view_data      = [];
        $this->module_title       = "Employee";
        $this->module_view_folder = "admin.employee";
        $this->module_url_path    =  url(config('app.project.admin_panel_slug').'/employee');
       


    }

    //Display Records
    
    public function index(){

        $employee                               = $this->BaseModel::with('company')->sortable()->paginate(2);
        $this->arr_view_data['employee']        = $employee;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.index',$this->arr_view_data)->with('number', 1);
        
    }
    // Create Records  

    public function create(){

        $company                               = $this->Company::get();
        $this->arr_view_data['company']        = $company;

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    // Store Records  

    public function store(Request $request){
        
        $arr_rules = [];

        $arr_rules['first_name']        = 'required';
        $arr_rules['last_name']         = 'required';
        $arr_rules['email']             = 'required';
        $arr_rules['phone']             = 'required';
        $arr_rules['company_id']        = 'required';
    
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }
        
        $email    = $request->input('email');
        $is_exist = $this->BaseModel->where('email',$email)
                                    ->count();
        if($is_exist > 0)
        {
            return back()->with('error','Email id already exist.');
      
        }
        
        $arr_data['first_name']       = $request->input('first_name')??'';
        $arr_data['last_name']        = $request->input('last_name')??'';
        $arr_data['email']            = $request->input('email');
        $arr_data['phone']            = $request->input('phone');
        $arr_data['company_id']       = $request->input('company_id');

       
        $status = $this->BaseModel->create($arr_data);
        if($status)
        { 
            return back()->with('success','Record Created successfully');
        }
        else
        {
            return back()->with('error','Problem occured while updating');
           
        }
    
        return redirect()->back();
     
       
 
    }

      // Edit Records  

    public function edit($enc_id){

        $id            = base64_decode($enc_id);
        $arr_employee  = [];
        $obj_employee  = $this->BaseModel::find($id);

        if($obj_employee)
        {
            $arr_employee = $obj_employee->toArray();
        }

        $company                               = $this->Company::get();
        $this->arr_view_data['arr_employee']   = $arr_employee;
        $this->arr_view_data['company']        =  $company;
        

        return view($this->module_view_folder.'.edit',$this->arr_view_data);
   

    }

     // Update Records  

    public function update(Request $request){

        
        $arr_rules = [];

        $arr_rules['first_name']        = 'required';
        $arr_rules['last_name']         = 'required';
        $arr_rules['email']             = 'required';
        $arr_rules['phone']             = 'required';
        $arr_rules['company_id']        = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
    
             return Redirect::back()->withErrors($validator);
    
        }
        
        $id = base64_decode($request->input('enc_id'));

        $email    = $request->input('email');
        $is_exist = $this->BaseModel->where('email',$email)
                                    ->where('id','<>',$id)
                                    ->count();
        if($is_exist > 0)
        {
            return back()->with('error','Email id already exist.');
    
        }
    
        $id                           = base64_decode($request->input('enc_id'));
        $arr_data['first_name']       = $request->input('first_name');
        $arr_data['last_name']        = $request->input('last_name');
        $arr_data['email']            = $request->input('email');
        $arr_data['phone']            = $request->input('phone');
        $arr_data['company_id']       = $request->input('company_id');

        $status = $this->BaseModel->where('id',$id)->update($arr_data);

        if($status)
        { 
            return back()->with('success','Record updated successfully');
        }
        else
        {
            return back()->with('error','Problem occured while updating');
        
        }

        return redirect()->back();

    }

      // Delete Records  

    public function delete($enc_id){

        $id         = base64_decode($enc_id);

        $employee   = $this->BaseModel::find($id);
        $employee->delete();

        return back()->with('success','Record deleted Successfully');
       
    }

   
}
