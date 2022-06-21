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

        $last_30days = Carbon::now()->subDays(30);

        $vistors = Vistor::all();
        $employees = Employee::all();
        $users = User::all();
        $companies = Company::all();
        $companiesActive = Company::where(['state'=> true])->count();

        $last_30['vistors'] = DB::table('card_taps')->distinct('ID_Card')->where(['card_type'=>"VISTOR"])->where('tapped_at', '>=', $last_30days)->count();
        $inInstitution['vistors'] = Vistor::where(['status'=> "IN"])->count();
        $inInstitution['employee'] = Employee::where(['state'=> "IN"])->count();



        return Inertia::render('Dashboard', ['vistors' => $vistors, 'employees' => $employees, 'users' => $users, 'companies' => $companies, 'last_30days'=>$last_30, 'inInstitution' => $inInstitution, 'companiesActive' => $companiesActive]);
    }

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
