<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Employee extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'company_id',
        'email',
        'phone'
    
     ];


    public function company(){

     return   $this->belongsTo('\App\Models\Company','company_id','id')->withDefault([
        'name' => 'Not Avail'
    ]);


    }

     
  
}


