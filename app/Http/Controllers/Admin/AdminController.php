<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\CardTap;
use App\Models\Admin\Company;
use App\Models\Admin\Employee;
use App\Models\Admin\Vistor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $taps = CardTap::orderBy('tapped_at', 'DESC')->pluck('tapped_at')->toArray();


        $visitors = Vistor::with('taps')->get();
        $employees = Employee::with('taps')->get();

        $ymdDate = array_map(function ($el) {

            return date('Y-m-d', strtotime($el));
        }, $taps);


        $noDuplicate = array_slice(array_map(function ($el) {
            return $el;
        }, array_unique($ymdDate)), 0);

        $daysTaps = [];

        $noDuplicate = array_slice($noDuplicate, 0, 5);


        foreach ($noDuplicate as $t) {

            foreach ($visitors->toArray() as $visitor) {

                // dd(array_map( function($tap){ return date('Y-m-d', strtotime($tap['tapped_at']));
                // },$visitor['taps']), $t);

     
                    if ( in_array($t, array_map(function ($tap) {

                        return date('Y-m-d', strtotime($tap['tapped_at']));
    
                    }, $visitor['taps'])) ) {

                        // dd($visitor['taps'], $t, in_array($t, array_map(function ($tap) {

                        //     return date('Y-m-d', strtotime($tap['tapped_at']));

        
                        // }, $visitor['taps'])), array_map(function ($el){return $el['tapped_at'];},$visitor['taps']), array_filter($visitor['taps'], function($element) use($t){
                        //     return date('Y-m-d', strtotime($element['tapped_at'])) == $t;
                        // }) );
    
                        if (array_key_exists($t, $daysTaps)) {

                            array_push($daysTaps[$t], $visitor);
                        } else {
    
                            $daysTaps[$t] = [];
                            array_push($daysTaps[$t], $visitor);
                        }
                }


            }


        }

        // dd($daysTaps['2022-06-19']);


        // in_array($t, $this->getTapsTime($element['taps']) )

        // dd(array_filter($visitors->toArray(), function ($element) use($noDuplicate) {
        //     return in_array($noDuplicate[0], $this->getTapsTime($element['taps']));
        // })[3],$noDuplicate[0]);


        // dd(array_map(function($element){
        //     return $element['id'];
        // }, $daysTaps['2022-06-19']));


        // dd(array_unique($daysTaps['2022-06-19']));


        // dd(array_unique(array_map(function ($el){ return $el['ID_Card'];}, $daysTaps['2022-06-18'])));



        // dd(array_slice($daysTaps,2,6)[0]);

        // $ordered = array_map(function($el) use($visitors) {return array_filter($visitors->toArray(), function($visitor){

        //     return $visitor['taps'];

        // }); }, $noDuplicate);

        // dd(array_fill_keys(range(0, count($noDuplicate)-1), $noDuplicate));

        // dd(array_map(function($el){ return $el['tapped_at'];
        // },$visitors[0]['taps']->toArray()));

        

        return view('admin.dashboard', compact('employees'));

        $last_30days = Carbon::now()->subDays(30);

        $vistors = Vistor::all();
        $employees = Employee::all();
        $users = User::all();

        // $companies = Company::all();
        // $companiesActive = Company::where(['state'=> true])->count();

        $last_30['vistors'] = DB::table('card_taps')->distinct('ID_Card')->where(['card_type' => "VISTOR"])->where('tapped_at', '>=', $last_30days)->count();
        $inInstitution['vistors'] = Vistor::where(['status' => "IN"])->count();
        $inInstitution['employee'] = Employee::where(['state' => "IN"])->count();

        return Inertia::render('Dashboard', ['vistors' => $vistors, 'employees' => $employees, 'users' => $users, 'last_30days' => $last_30, 'inInstitution' => $inInstitution]);
    }

    public function getTapsTime($visitorTaps)
    {

        return array_map(function ($el) {
            return date('Y-m-d', strtotime($el['tapped_at']));
        }, $visitorTaps);
    }



    ///////////////////////////// \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\|

    public function vistors()
    {
        return Inertia::render('Vistors');
    }
    public function employees()
    {
        return Inertia::render('Employees');
    }
    public function companies()
    {
        return Inertia::render('Companies');
    }

    public function equipments()
    {
        return Inertia::render('Equipments');
    }
}
