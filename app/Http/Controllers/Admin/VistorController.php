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

        // $filters = $request->all('searchFrom', 'searchTo', 'selected');
  
        // $taps = json_encode(['taps' => CardTap::paginate()]);

        // $vistors = new VisitorCollection(
        //     Vistor::paginate(60)
        // );



        $employees = Vistor::all();

        return view('admin.visitors');
        return Inertia::render('Vistors/Index', ['vistors' => $vistors, 'filters' => $filters, 'taps' => $taps]);
    }
}
