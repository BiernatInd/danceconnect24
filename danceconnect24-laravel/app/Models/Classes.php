<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'id',
        'class_name',
        'markings',
        'class_type',
        'places',
        'room',
        'instructor',
        'date',
        'time_start',
        'time_end'
    ];
}
