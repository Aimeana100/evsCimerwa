<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Admin\Vistor;
use Illuminate\Http\Request;
use App\Models\Admin\CardTap;
use App\Models\Admin\Employee;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardTapCollection;
use App\Http\Resources\VisitorCollection;

class VistorController extends Controller
{
    public function vistors(Request $request)
    {
        //  dd(CardTap::where('tapped_at', '>=' , '2022-5-24')->get('tapped_at'));

        $filters = $request->all('searchFrom', 'searchTo', 'selected');
        $vistors = new VisitorCollection(
            Vistor::filter(
                $request->all('searchFrom', 'searchTo', 'selected')
            )

                ->paginate(1000)
                ->appends($request->all())
        );

        // $vistors = $vistors->values()->all();

        //  dd (DB::table('vistors')->join(DB::raw('(SELECT * FROM card_taps ORDER BY id DESC LIMIT 1) latestTap'), function($join){
        //      $join->on('vistors.id', '=', 'latestTap.user_id');
        // } )->get());

        // $taps = new CardTapCollection(CardTap::all()); dd($taps);

        $taps = json_encode(['taps' => CardTap::paginate()]);
        // dd(CardTap::all());
        // dd($vistors);

        return Inertia::render('Vistors/Index', ['vistors' => $vistors, 'filters' => $filters, 'taps' => $taps]);
    }
}
