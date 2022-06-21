<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardTap extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ID_Card',
        'tapped_at',
        'card_type',
        'status'
    ];

    public function visitor(){
        return $this->belongsTo(Vistor::class, 'user_id');
    }

    public function employee(){
        return $this->belongsTo(Vistor::class, 'user_id');
    }
}
