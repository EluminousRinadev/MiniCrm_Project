<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Company extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website'
       
    
     ];

}
