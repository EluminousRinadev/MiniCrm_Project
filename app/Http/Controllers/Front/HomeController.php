<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Models
use App\Models\Employee;
use App\Models\Company;

class HomeController extends Controller
{
    public function __construct(){
        $this->Employee                             = new Employee();
        $this->Company                              = new Company();
        $this->logoPublicPath                       =  url('/').'/storage/app/public/';
        $this->logoBasePath                         =  base_path().'/storage/app/public/';
        $this->arrViewData                          = [];
    }
    
    public function index(){
                                           
        $this->arrViewData['company']  = $this->Company->limit(6)->get();
        $this->arrViewData['logoPublicPath']  =  $this->logoPublicPath;
        $this->arrViewData['logoBasePath']  = $this->logoBasePath ;
        
        return view('front.index', $this->arrViewData);
    }

    public function companyDetails($encId){
        $intUserId=base64_decode($encId);
        dd($intUserId);
    }
}