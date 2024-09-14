<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone_number',
        'sex',
        'sign_up_type',
        'classes_id',
        'user_id',
        'price',
    ];
}
