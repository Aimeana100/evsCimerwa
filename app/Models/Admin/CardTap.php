<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected function getDateTappedAttribute($value) 
    {
        return  date_format(date_create($value), 'yy-m-d');
    }

    public function scopeFilter($query){
        $query->where();
    }


    public function scopeFildter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('names', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('company', 'like', '%' . $search . '%');
        })->when(
            $filters['selected'] ?? null,
            function ($query, $filter) {
                $query->SelectedFilter($filter);
            }
        );
    }


    public function visitor(){
        return $this->belongsTo(Vistor::class, 'user_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'user_id');
    }
}
