<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadsData extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'leadsdata';

    // The attributes that are mass assignable
    protected $fillable = [
        'customer_name',
        'sales_name',
        'contact_number',
        'product',
        'status',
        'source_leads',
        'note',
        'method',
        'target_price',
        'fixed_price',
    ];

    // The attributes that should be hidden for arrays
    protected $hidden = [];

    // The attributes that should be cast to native types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Optional: Specify the column name for deleted_at if you use a custom name
    // protected $dates = ['deleted_at'];
}
