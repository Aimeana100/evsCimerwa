<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vistor extends Model
{
    use HasFactory;
    protected $fillable = [
        'names',
        'gender',
        'ID_Card',
        'vistors',
        'allTaps',
        'phone',
        'dateJoined',
        'latestTap',
        // 'dayTap',
        'reason',
        'status',
    ];

    public function taps()
    {
        return $this->hasMany(CardTap::class, 'ID_Card', 'ID_Card');
    }

    public function scopeSelectedFilter($query, $selected)
    {
        switch ($selected) {
            case 'inGate':
                return $query->where('status', 'IN');
                break;
            case 'outGate':
                return $query->where('status', 'OUT');
                break;
            default:
                # code...
                break;
        }
    }

    public function scopeDateRange($query, $selected)
    {
        switch ($selected) {
            case 'inGate':
                return $query->where('status', 'IN');
                break;
            case 'outGate':
                return $query->where('status', 'OUT');
                break;
            default:
                # code...
                break;
        }
    }

    public function scopeFilter($query, array $filters)
    {
        $query
        ->when($filter['searchTo'] ?? null, function ($query, $to) {
            $query->Where('dateJoined', '<=', $to);
        })->when($filters['searchFrom'] ?? null, function ($query) use ($filters) {
            $query->where('dateJoined', '>=', $filters['searchFrom']);
        })
            ->when(
                $filters['selected'] ?? null,
                function ($query, $filter) {
                    $query->SelectedFilter($filter);
                }
            );
    }
}
