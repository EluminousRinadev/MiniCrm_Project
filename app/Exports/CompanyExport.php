<?php

namespace App\Exports;

use App\Models\company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class CompanyExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    use Exportable;
	private $data;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($data)
	{ 
        $this->CompanyModel = new Company();
        $this->BaseModel = $this->CompanyModel;
        $this->data      = $data;
	}
    
    public function collection()
    {

         
        $search 		  = $this->data;      
        $arrData         = array();

        $objData   = $this->BaseModel;

        // dd($search['q_name']);

        if(isset($search['q_name']) && $search['q_name']!='')
        {
            $searchTerm = $search['q_name'];
            $objData = $objData->where('name',$searchTerm);
            // dd( $objData);
        }

        if(isset($search['q_email']) && $search['q_email']!='')
        {
            $searchTerm = $search['q_email'];
            $objData = $objData->where('email', 'like', '%'.$searchTerm.'%');
        }

        if(isset($search['q_website']) && $search['q_website']!='')
        {
            $searchTerm = $search['q_website'];
            $objData = $objData->where('website', 'like', '%'.$searchTerm.'%');
        }

        if(isset($search['q_status']) && $search['q_status']!='')
        {
            $searchTerm = $search['q_status'];
            $objData = $objData->where('status', 'like', '%'.$searchTerm.'%');
        }

        $objData = $objData->orderBy('id','DESC')->get();     

        if ( !$objData->isEmpty() ) {
            $arrData = $objData->toArray();
        }

        $arrCompany=[];
        
        if(sizeof($arrData)>0){

            if(isset($arrData) && sizeof($arrData)>0)
            {
                foreach($arrData as $key=>$data)
                {  
                    $arrTemp['id']                            = $data['id'] ?? '';
                    $arrTemp['name']                          = $data['name'] ?? '';
                    $arrTemp['email ']                        = $data['email '] ?? '';
                    $arrTemp['logo ']                         = $data['logo '] ?? '';
                    $arrTemp['website ']                      = $data['website '] ?? '';
                    $arrTemp['created_at']                    = isset($data['created_at']) ? date('d/m/Y',strtotime($data['created_at'])) :'-';

                    array_push($arrCompany, $arrTemp);
                }
            }
        }
        
        // dd($arrCompany);

        return  collect($arrCompany);
    //     return company::all();
    }


    public function headings(): array
    {
        return [
            'Sr No.',
            'Name',
            'Email',
            'Logo',
            'Website',
            'Date/Time'
        ];
    }
}