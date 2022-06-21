<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GateKeeper extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'names',
        'username',
        'password',
        'session_status',
        'status',
    ];
}