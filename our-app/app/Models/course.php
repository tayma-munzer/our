<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    use HasFactory;
    protected $fillable = [
        'c_name',
        'c_desc',
        'c_price',
        'c_img',
        'u_id',
    ];
}
