<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Falsh;
use Illuminate\Support\Facades\Redirect;
use App\Imports\CompanyImport;
use App\Exports\CompanyExport;
use Maatwebsite\Excel\Facades\Excel;
// Models
use App\Models\Employee;
use App\Models\Company;
// plugins
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
        $arrOrder = $request->input('order', null);
        $search    = $request->input('column_filter', null);
        
        $orderByColumn = 'id';
        $orderByType   = 'ASC';
        
        if(isset($arrOrder[0]['column']) && isset($request->input('columns')[$arrOrder[0]['column']]['name'])){   
             $orderByType    = $arrOrder[0]['dir'] ?? 'DESC';
            $orderByColumn   = $request->input('columns')[$arrOrder[0]['column']]['name'];
        }
        $objData = $this->BaseModel;
       

        if(isset($search['q_name']) && $search['q_name']!='')
        {
            $searchTerm = $search['q_name'];
            $objData = $objData->where('name', 'like', '%'. $searchTerm.'%');
        }

       
        if(isset($search['q_email']) && $search['q_email']!='')
        {
             $searchTerm = $search['q_email'];
            $objData     = $objData->where('email', 'like', '%'. $searchTerm.'%');

          
        }

        if(isset($search['q_website']) && $search['q_website']!='')
        {
             $searchTerm = $search['q_website'];
            $objData = $objData->where('website', 'like', '%'. $searchTerm.'%');

          
        }
        
        if(isset($search['q_status']) && $search['q_status']!='')
        {
             $searchTerm = $search['q_status'];
             $objData    = $objData->where('status', '=',  $searchTerm);
        }
        
        $objData         = $objData->orderBy($orderByColumn, $orderByType );
        $jsonResult      = DataTables::of($objData)->make(true);
        $objJsonResult   = $jsonResult->getData();
        
        if(isset($objJsonResult->data) && sizeof($objJsonResult->data)>0)
        {
            foreach ($objJsonResult->data as $key => $data) 
            {
                $statusBtn = '';
                if($data->status != null && $data->status == "0")
                {   

                    
                    $statusBtn = ' <a href="'.$this->moduleUrlPath.'/active/'.base64_encode($data->id).'"
                    onclick="return confirm_action(this,event,\'Do you really want to activate this record ?\')"><button
                        type="button" class="btn btn-primary btn-sm"
                        style="background-color: #bd0f20;" >DeActive </button><a>';
                    
                   
                }
                elseif($data->status != null && $data->status == "1")
                {
             
                $statusBtn = ' <a href="'.$this->moduleUrlPath.'/deactive/'.base64_encode($data->id).'"
                onclick="return confirm_action(this,event,\'Do you really want to inactivate this record ?\')"><button
                type="button" class="btn btn-primary btn-sm"
                style="background-color: #208336;">Active
                 </button><a>';
                    
             
                }

                $actionBtn = '-';

                $editHref  = $this->moduleUrlPath.'/edit/'.base64_encode($data->id);
                $deleteHref  = $this->moduleUrlPath.'/delete/'.base64_encode($data->id);

                $actionBtn = '<a class="mb-6 btn-floating waves-effect waves-light brown darken-4" href="'.$editHref.'" title="Edit"><i style="font-size:24px color: #000000;" class="fas">&#xf303;</i></a><br><a class="mb-6 btn-floating waves-effect waves-light brown darken-4" href="'.$deleteHref.'" title="Edit"><i class="fa fa-trash" aria-hidden="true" style="color:#bd251f;"></i></a>';

                $image="";
                
               

                if(isset($data->logo) && $data->logo!=''){

                    $image = ' <img src="'.$this->logo_image_public_path.$data->logo.'" alt="" height="100"
                    width="100">';
                    // dd($image);
                }else{

                    // $image = '<img src="'.$this->logo_image_public_path.$data['logo'].'" alt="" height="100"
                    // width="100">';

                  
                }

                

                $objJsonResult->data[$key]->id                   = base64_encode($data->id);
                $objJsonResult->data[$key]->name                 = $data->name ?? '';
                $objJsonResult->data[$key]->email                = $data->email ?? '';
                $objJsonResult->data[$key]->website              = $data->website ?? '';
                $objJsonResult->data[$key]->logo                 = $image ;
                $objJsonResult->data[$key]->statusBtn           = $statusBtn;
                $objJsonResult->data[$key]->actionBtn           = $actionBtn;
            }
        }
        return response()->json($objJsonResult);
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

                        if (isset($objData->logo) && $objData->logo!="") 
                        {
                        $path = $this->logo_image_base_img_path .'/'.$objData->logo;

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

        if(isset($employee->logo)){
       
        if (File::exists($image_path)) {
        
            unlink($image_path);
        }
        
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

    //To Activate Company of Records 
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

   //To Import Company of Records 

    public function import (Request $request){
        $arrRules = [];
        $arrRules['selectFile'] ='required|mimes:xls,xlsx';
    
    
        $validator = Validator::make($request->all(),$arrRules);
        if($validator->fails()){
        return Redirect::back()->withErrors($validator);
        }

        $test=Excel::import(new CompanyImport,request()->file('selectFile'));
          
        return back();
    
    }

    public function export(Request $request) 
    {
        // dd($request->all());
        $arrformData = $request->all();
        return Excel::download( new CompanyExport($arrformData), 'company.xlsx' );
    }

}