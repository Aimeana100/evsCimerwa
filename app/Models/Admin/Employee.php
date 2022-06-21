<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'names',
        'genger',
        'NID',
        'phone',
        'ID_Card',
        'company',
        'dateJoined',
        'latestTap',
        'status',
        'state'
    ];

    public function scopeSelectedFilter($query, $selected)
    {
        switch ($selected) {
            case 'inGate':
                return $query->where('status', 'IN');
                break;
            case 'activated':
                return $query->where('state', true);
            case 'banned':
                return $query->where('state', false);
            default:
                # code...
                break;
        }
    }

    public function scopeFilter($query, array $filters)
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
}
