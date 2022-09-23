<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Admin\Vistor;
use Illuminate\Http\Request;
use App\Models\Admin\CardTap;
use App\Models\Admin\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\CardTapCollection;
use App\Http\Resources\EmployeeCollection;

use PDF;

class EmployeeController extends Controller
{
    public function employees(Request $request)
    {
        // $filters = $request->all('search', 'selected', 'onDate');
        // $employees = new EmployeeCollection(
        //     Employee::filter(
        //         $request->all('search', 'selected')
        //     )
        //         ->paginate()
        //         ->appends($request->all())
        // );

        $employees = Employee::all();

        return view('admin.employees');


        return Inertia::render('Employees/Index', ['employees' => $employees, 'filters' => $filters]);
    }

    public function employeesAttendance(Request $request){


        // $filters = $request->all('search', 'selected', 'onDate');


        // $employees = new EmployeeCollection(
        //     Employee::filter(
        //         $request->all('search', 'selected')
        //     )
        //         ->paginate()
        //         ->appends($request->all())
        // );


        $taps = CardTap::orderBy('tapped_at', 'DESC')->pluck('tapped_at')->toArray();


        $visitors = Vistor::with('taps')->get();

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

                // dd($visitor['id']);

                // dd(array_map( function($tap){ return date('Y-m-d', strtotime($tap['tapped_at']));
                // },$visitor['taps']), $t);

                    if ( in_array($t, array_map(function ($tap) {

                        return date('Y-m-d', strtotime($tap['tapped_at']));
    
                    }, $visitor['taps'])) ) {

                        // dd($visitor['taps'], $t, in_array($t, array_map(function ($tap) {

                        //     return date('Y-m-d', strtotime($tap['tapped_at']));

                        // }, $visitor['taps'])), array_map(function ($el){return $el['tapped_at'];},$visitor['taps']), 
                        // array_filter($visitor['taps'], function($element) use($t){
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




        return view('admin.attendance', ['filter'=>$noDuplicate[0], 'daysTaps'=>$daysTaps[$noDuplicate[0]]]);


        // return Inertia::render('EmployeesAttendance/Index', ['employees' => $employees, 'filters' => $filters]);
    }



    public function employeesAttendanceDownload(Request $request){



        $taps = CardTap::orderBy('tapped_at', 'DESC')->pluck('tapped_at')->toArray();


        $visitors = Vistor::with('taps')->get();

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

                // dd($visitor['id']);

                // dd(array_map( function($tap){ return date('Y-m-d', strtotime($tap['tapped_at']));
                // },$visitor['taps']), $t);

                    if ( in_array($t, array_map(function ($tap) {

                        return date('Y-m-d', strtotime($tap['tapped_at']));
    
                    }, $visitor['taps'])) ) {

                        // dd($visitor['taps'], $t, in_array($t, array_map(function ($tap) {

                        //     return date('Y-m-d', strtotime($tap['tapped_at']));

                        // }, $visitor['taps'])), array_map(function ($el){return $el['tapped_at'];},$visitor['taps']), 
                        // array_filter($visitor['taps'], function($element) use($t){
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


           

           //in Controller
           $path1 = 'user_assets/assets/images/CIMERWALogo.png';

           $type1 = pathinfo($path1, PATHINFO_EXTENSION);
           $data1 = file_get_contents($path1);
           $logo1 = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);




           //in Controller    
           $path2 = 'user_assets/assets/images/santech.png';
           $type2 = pathinfo($path2, PATHINFO_EXTENSION);
           $data2 = file_get_contents($path2);
           $logo2 = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);




    

          $pdf = PDF::loadview('report',[ 'logo1'=> $logo1, 'logo2'=> $logo2,'filter'=>$noDuplicate[0], 'daysTaps'=>$daysTaps[$noDuplicate[0]]]);

          return $pdf->download('attendance.pdf');

        exit();

        $pdf = PDF::loadview('admin.attendance', ['filter'=>$noDuplicate[0], 'daysTaps'=>$daysTaps[$noDuplicate[0]]]);
        return $pdf->download('attendance.pdf');

    }

    public function employeeBurn(Employee $employee)
    {
        $message = $employee->state ? "Burned to Pass the gate in" : "Granted to Pass the gate in";
        $employee->update(['state' => !$employee->state]);

        return Redirect::back()->with('success', 'Employee State has ' . $message);
    }

    public function employeeOne(Request $request, $id){
        $filters = $request->all('search', 'selected', 'onDate');
        $employees = new EmployeeCollection(
            Employee::where('id', $id)->filter(
                $request->all('search', 'selected')
            )
                ->paginate()
                ->appends($request->all() )
        );

        // dd($employees);



        return Inertia::render('EmployeesAttendance/Employee', ['employees' => $employees, 'filters' => $filters]);
    }
}
