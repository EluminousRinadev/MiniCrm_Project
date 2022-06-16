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
        $this->arrViewData      = [];
        $this->module_title       = "Employee";
        $this->moduleViewFolder = "admin.employee";
        $this->moduleUrlPath    =  url(config('app.project.admin_panel_slug').'/employee');
       


    }

    //To show List of Employee 
    
    public function index(){

        $employee                               = $this->BaseModel::with('company')->get();
        $this->arrViewData['employee']          = $employee;
        $this->arrViewData['moduleUrlPath']     = $this->moduleUrlPath;

        return view($this->moduleViewFolder.'.index',$this->arrViewData)->with('number', 1);
        
    }
    //To Create Employee of Records  

    public function create(){

        $company                               = $this->Company::get();
        $this->arrViewData['company']        = $company;

        return view($this->moduleViewFolder.'.create',$this->arrViewData);
    }

    // To Store Employee of Records  

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
        $isExist  = $this->BaseModel->where('email',$email)
                                    ->count();
        if($isExist > 0)
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

      //To Edit Employee of Records  

    public function edit($enc_id){

        $id            = base64_decode($enc_id);
        $arr_employee  = [];
        $obj_employee  = $this->BaseModel::find($id);

        if($obj_employee)
        {
            $arr_employee = $obj_employee->toArray();
        }

        $company                               = $this->Company::get();
        $this->arrViewData['arr_employee']   = $arr_employee;
        $this->arrViewData['company']        =  $company;
        

        return view($this->moduleViewFolder.'.edit',$this->arrViewData);
   

    }

     //To Update Employee of Records  

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
        $isExist = $this->BaseModel->where('email',$email)
                                    ->where('id','<>',$id)
                                    ->count();
        if($isExist > 0)
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

      //To Delete Employee of Records  

    public function delete($enc_id){

        $id         = base64_decode($enc_id);

        $employee   = $this->BaseModel::find($id);
        $employee->delete();

        return back()->with('success','Record deleted Successfully');
       
    }
     //To Activate Employee of Records  
    public function deactive($enc_id){
    
        $id         = base64_decode($enc_id);
        $status     = $this->BaseModel->where('id',$id)->update(['status'=>'1']);
      
        if($status){ 
            return back()->with('success','Record updated successfully');
        }else{
            return back()->with('error','Problem occured while updating');
        }

        return redirect()->back();
    }

     //To Deactivate Employee of Records  

    public function active($enc_id){

        $id         = base64_decode($enc_id);
        $status     = $this->BaseModel->where('id',$id)->update(['status'=>'0']);
      
        if($status) { 
            return back()->with('success','Record Updated successfully');
        }
        else{
            return back()->with('error','Problem occured while updating');
        }

        return redirect()->back();
    }




  
}