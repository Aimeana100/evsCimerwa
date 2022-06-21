<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GateKeeperLog extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'session',
        'logDate',
        'gate_keeper_id',
        'loginDevice',
    ];
}
