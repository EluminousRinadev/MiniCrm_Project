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

class CompanyController extends Controller
{
    public function __construct(){

        $this->Employee                             = new Employee();
        $this->Company                              = new Company();
        $this->BaseModel                            = $this->Company;
        $this->arr_view_data                        = [];
        $this->module_title                         = "Company";
        $this->module_view_folder                   = "admin.company";
        $this->module_url_path                      =  url(config('app.project.admin_panel_slug').'/company');
        $this->logo_image_public_path               =  url('/').'/storage/app/public/';
        $this->logo_image_base_img_path             =  base_path().'/storage/app/public/';

       
    }

    // Disply Records

    public function index(){

        $company                                           = $this->BaseModel::sortable()->paginate(1);
        $this->arr_view_data['company']                    = $company;
        $this->arr_view_data['module_url_path']            = $this->module_url_path;
        $this->arr_view_data['logo_image_base_img_path']   = $this->logo_image_base_img_path;
        $this->arr_view_data['logo_image_public_path']     = $this->logo_image_public_path;

        return view($this->module_view_folder.'.index',$this->arr_view_data)->with('number', 1);
        
    }

    // Create Records

    public function create(){

        return view($this->module_view_folder.'.create');
    }

    // stored Records
    public function store(Request $request){
       
        
        $arr_rules = [];

        $arr_rules['name']        = 'required';
        $arr_rules['email']       = 'required';
        $arr_rules['website']     = 'required';
     
    
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
        
        if($request->hasFile('logo'))
        {

            $file_name      = $request->input('logo');
            $file_extension = strtolower($request->file('logo')->getClientOriginalExtension());

           
             //image validation
            if(in_array($file_extension,['png','jpg','jpeg']))
            {

                 $file_name = time().'.'.$request->logo->extension();  
                 $isUpload  = $request->file('logo')->move($this->logo_image_base_img_path,$file_name);

             if($isUpload)
                {
                     $arr_data['logo'] = $file_name;
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
    // Edit Records
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


    return view($this->module_view_folder.'.edit',$this->arr_view_data);
   

    }
    // Update Records
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

    // Delete Records

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




}
