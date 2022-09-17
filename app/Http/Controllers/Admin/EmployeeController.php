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

class EmployeeController extends Controller
{
    public function employees(Request $request)
    {
        $filters = $request->all('search', 'selected', 'onDate');
        $employees = new EmployeeCollection(
            Employee::filter(
                $request->all('search', 'selected')
            )
                ->paginate()
                ->appends($request->all())
        );

        return Inertia::render('Employees/Index', ['employees' => $employees, 'filters' => $filters]);
    }

    public function employeesAttendance(Request $request){
        $filters = $request->all('search', 'selected', 'onDate');
        $employees = new EmployeeCollection(
            Employee::filter(
                $request->all('search', 'selected')
            )
                ->paginate()
                ->appends($request->all())
        );

        // dd($employees);


        return Inertia::render('EmployeesAttendance/Index', ['employees' => $employees, 'filters' => $filters]);
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
