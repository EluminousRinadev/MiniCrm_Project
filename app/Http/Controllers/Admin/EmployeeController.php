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
use DataTables;
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


    public function load_data(Request $request)
    {
        $arr_order = $request->input('order', null);
        $search    = $request->input('column_filter', null);
        
        $order_by_column = 'id';
        $order_by_type   = 'ASC';
        if(isset($arr_order[0]['column']) && isset($request->input('columns')[$arr_order[0]['column']]['name'])){   
            $order_by_type   = $arr_order[0]['dir'] ?? 'DESC';
            $order_by_column = $request->input('columns')[$arr_order[0]['column']]['name'];
        }
        $obj_data = $this->BaseModel->with(['company'=>function($q){
            $q->select('id','name');
          
        }]);
       

        if(isset($search['q_first_name']) && $search['q_first_name']!='')
        {
            $search_term = $search['q_first_name'];
            $obj_data = $obj_data->where('first_name', 'like', '%'.$search_term.'%');
        }

        if(isset($search['q_last_name']) && $search['q_last_name']!='')
        {
            $search_term = $search['q_last_name'];
            $obj_data = $obj_data->where('last_name', 'like', '%'.$search_term.'%');
        }

        if(isset($search['q_email']) && $search['q_email']!='')
        {
            $search_term = $search['q_email'];
            $obj_data = $obj_data->where('email', 'like', '%'.$search_term.'%');

          
        }

      
        if(isset($search['q_company']) && $search['q_company']!='')
        {
            $search_term = $search['q_company'];
            $obj_data = $obj_data->whereHas('company', function($q) use ($search_term){
                $q->where('id', 'like', '%'.$search_term.'%');
            });

          
        }

        if(isset($search['q_status']) && $search['q_status']!='')
        {
            $search_term = $search['q_status'];
            $obj_data = $obj_data->where('status', '=', $search_term);
        }
        
        $obj_data        = $obj_data->orderBy($order_by_column,$order_by_type);
        $json_result     = DataTables::of($obj_data)->make(true);
        $obj_json_result = $json_result->getData();
        
        if(isset($obj_json_result->data) && sizeof($obj_json_result->data)>0)
        {
            foreach ($obj_json_result->data as $key => $data) 
            {
                $status_btn = '';
                if($data->status != null && $data->status == "0")
                {   
                    $status_btn = ' <a href="'.$this->moduleUrlPath.'/active/'.base64_encode($data->id).'"
                    onclick="return confirm_action(this,event,\'Do you really want to activate this record ?\')"><button
                        type="button" class="btn btn-primary btn-sm"
                        style="background-color: #208336;">DeActive </button><a>';
                    
                   
                }
                elseif($data->status != null && $data->status == "1")
                {
             
                $status_btn = ' <a href="'.$this->moduleUrlPath.'/deactive/'.base64_encode($data->id).'"
                onclick="return confirm_action(this,event,\'Do you really want to inactivate this record ?\')"><button
                type="button" class="btn btn-primary btn-sm"
                style="background-color: #bd0f20;">Active
                 </button><a>';
                    
             
                }

                $action_btn = '-';

                $edit_href  = $this->moduleUrlPath.'/edit/'.base64_encode($data->id);
                $delete_href  = $this->moduleUrlPath.'/delete/'.base64_encode($data->id);

                $action_btn = '<a class="mb-6 btn-floating waves-effect waves-light brown darken-4" href="'.$edit_href.'" title="Edit"><i style="font-size:24px color: #000000;" class="fas">&#xf303;</i></a><br><a class="mb-6 btn-floating waves-effect waves-light brown darken-4" href="'.$delete_href.'" title="Edit"><i class="fa fa-trash" aria-hidden="true" style="color:#bd251f;"></i></a>';

             
             
                $obj_json_result->data[$key]->id                   = base64_encode($data->id);
                $obj_json_result->data[$key]->first_name           = $data->first_name ?? '';
                $obj_json_result->data[$key]->last_name            = $data->last_name ?? '';
                $obj_json_result->data[$key]->company              = $data->company->name ?? '';
                $obj_json_result->data[$key]->email                = $data->email ?? '';
                $obj_json_result->data[$key]->status_btn           = $status_btn;
                $obj_json_result->data[$key]->action_btn           = $action_btn;
            }
        }
        return response()->json($obj_json_result);
    }


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
        
        $status     = $this->BaseModel->where('id',$id)->update(['status'=>'0']);
        
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
        // dd($id);
        $status     = $this->BaseModel->where('id',$id)->update(['status'=>'1']);
      
        if($status) { 
            return back()->with('success','Record Updated successfully');
        }
        else{
            return back()->with('error','Problem occured while updating');
        }

        return redirect()->back();
    }




  
}