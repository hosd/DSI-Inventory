<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Productmodel extends Model
{
    use HasFactory,Notifiable;
    
    protected $table = 'product';

    protected $fillable = [
        'name',
        'categoryID',
        'productcode',
        'status',
        'designname',
        'designcode',
        'tyresize',
        'product_category',
        'unitprice',
        'customer_des',
        'product_des',
        'created_at',
        'updated_at'
    ];
}
