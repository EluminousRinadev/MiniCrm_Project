<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Falsh;
use Illuminate\Support\Facades\Redirect;
use File;
use DataTables;

class CompanyController extends Controller
{
    public function __construct(){

        $this->Employee                             = new Employee();
        $this->Company                              = new Company();
        $this->BaseModel                            = $this->Company;
        $this->arrViewData                          = [];
        $this->moduleTitle                          = "Company";
        $this->moduleViewFolder                     = "admin.company";
        $this->moduleUrlPath                        =  url(config('app.project.admin_panel_slug').'/company');
        $this->logo_image_public_path               =  url('/').'/storage/app/public/';
        $this->logo_image_base_img_path             =  base_path().'/storage/app/public/';

     
    }

       //To show List of Company

    public function index(){

        $company                                         = $this->BaseModel::get();
        $this->arrViewData['company']                    = $company;
        $this->arrViewData['moduleUrlPath']              = $this->moduleUrlPath;
       

        return view($this->moduleViewFolder.'.index',$this->arrViewData)->with('number', 1);
        
    }

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
        $obj_data = $this->BaseModel;
       

        if(isset($search['q_name']) && $search['q_name']!='')
        {
            $search_term = $search['q_name'];
            $obj_data = $obj_data->where('name', 'like', '%'.$search_term.'%');
        }

       
        if(isset($search['q_email']) && $search['q_email']!='')
        {
            $search_term = $search['q_email'];
            $obj_data = $obj_data->where('email', 'like', '%'.$search_term.'%');

          
        }

        if(isset($search['q_website']) && $search['q_website']!='')
        {
            $search_term = $search['q_website'];
            $obj_data = $obj_data->where('website', 'like', '%'.$search_term.'%');

          
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

                $image="";
                
               

                if(isset($data->logo) && $data->logo!=''){

                    $image = ' <img src="'.$this->logo_image_public_path.$data->logo.'" alt="" height="100"
                    width="100">';
                    // dd($image);
                }else{

                    // $image = '<img src="'.$this->logo_image_public_path.$data['logo'].'" alt="" height="100"
                    // width="100">';

                  
                }

                

                $obj_json_result->data[$key]->id                   = base64_encode($data->id);
                $obj_json_result->data[$key]->name                 = $data->name ?? '';
                $obj_json_result->data[$key]->email                = $data->email ?? '';
                $obj_json_result->data[$key]->website              = $data->website ?? '';
                $obj_json_result->data[$key]->logo                 = $image ;
                $obj_json_result->data[$key]->status_btn           = $status_btn;
                $obj_json_result->data[$key]->action_btn           = $action_btn;
            }
        }
        return response()->json($obj_json_result);
    }
    //To Create Company of Records  

     public function create(){

        return view($this->moduleViewFolder.'.create');
    }

     // To Store Company of Records  
    public function store(Request $request){
       
        
        $arr_rules = [];

        $arr_rules['name']        = 'required';
        $arr_rules['email']       = 'required';
        $arr_rules['website']     = 'required';
     
    
        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails()){
        return Redirect::back()->withErrors($validator);
        }
    
        $email    = $request->input('email');
        $isExist = $this->BaseModel->where('email',$email)
                                    ->count();

   
        if($isExist > 0)
        {
          
            return back()->with('error','Email id already exist.');
      
        }
        
        if($request->hasFile('logo'))
        {

            $fileName      = $request->input('logo');
            $fileExtension = strtolower($request->file('logo')->getClientOriginalExtension());

           
             //image validation
            if(in_array($fileExtension,['png','jpg','jpeg']))
            {

                 $fileName = time().'.'.$request->logo->extension();  
                 $isUpload  = $request->file('logo')->move($this->logo_image_base_img_path,$fileName);

             if($isUpload)
                {
                     $arr_data['logo'] = $fileName;
                }
            }
            else
            {
                 return redirect()->back();
            }
        }
        
    
        $arr_data['name']       = $request->input('name');
        $arr_data['email']      = $request->input('email');
        $arr_data['website']    = $request->input('website');
       
        $status = $this->BaseModel->create($arr_data);
        if($status)
        { 
            return back()->with('success','Created successfully');
        }
        else
        {
            return back()->with('error','Problem occured while updating');
           
        }
    
        return redirect()->back();
     
       
 
    }
     //To Edit Company of Records  

    public function edit($enc_id){

        $id           = base64_decode($enc_id);
        $arr_company  = [];
        $obj_company  = $this->BaseModel::find($id);

        if($obj_company)
        {
            $arr_company = $obj_company->toArray();
        }

    
        $this->arr_view_data['arr_company']                = $arr_company;
        $this->arr_view_data['logo_image_base_img_path']   =  $this->logo_image_base_img_path;
        $this->arr_view_data['logo_image_public_path']     =  $this->logo_image_public_path;


    return view($this->moduleViewFolder.'.edit',$this->arr_view_data);
   

    }
       //To Edit Update of Records  
    public function update(Request $request){

    
        $arr_rules = [];

        $arr_rules['name']        = 'required';
        $arr_rules['email']       = 'required';
        $arr_rules['website']     = 'required';
    
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
    
        $id                     = base64_decode($request->input('enc_id'));
        $arr_data['name']       = $request->input('name');
        $arr_data['email']      = $request->input('email');
        $arr_data['website']    = $request->input('website');
  

        if($request->hasFile('logo'))
        {

            $file_name      = $request->input('logo');

            $file_extension = strtolower($request->file('logo')->getClientOriginalExtension());

            if(in_array($file_extension,['png','jpg','jpeg']))
            {
                
                $file_name = time().'.'.$request->logo->extension();  

                $is_upload  = $request->file('logo')->move($this->logo_image_base_img_path,$file_name);


                if($is_upload)
                {
                    $arr_data['logo'] = $file_name;

                        if (isset($obj_data->logo) && $obj_data->logo!="") 
                        {
                        $path = $this->logo_image_base_img_path .'/'.$obj_data->logo;

                        if(file_exists($path))
                        {
                            unlink($path);
                        }
                    
                         }
                }
            }
            else
            {
                return back()->with('error','Invalid File type, While creating');
        
            }
        }
   
        $status = $this->BaseModel->where('id',$id)->update($arr_data);

        if($status)
        { 
            return back()->with('success','updated successfully');
        }
        else
        {
            return back()->with('error','Problem occured while updating');
        
        }

        return redirect()->back();

    }

     //To Delete Company of Records

    public function delete($enc_id){

        $id = base64_decode($enc_id);

        $employee  = $this->BaseModel::find($id);
       
        $image_path = $this->logo_image_base_img_path .'/'. $employee->logo;

        if (File::exists($image_path)) {
        
            unlink($image_path);
        }
        
        $employee->delete();

        return back()->with('success','Record deleted Successfully');
       
    }
     //To Activate Company of Records  

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

    //To Activate Employee of Records 
    public function active($enc_id){

        $id         = base64_decode($enc_id);
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