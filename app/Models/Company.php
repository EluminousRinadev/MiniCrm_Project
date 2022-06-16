<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory,Sortable,SoftDeletes;

    protected $table = 'companies';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website'
       
    
     ];

}
